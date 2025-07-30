<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\CallSignal;

class SignalingController extends Controller
{
    public function sendSignal(Request $request)
    {
        $request->validate([
            'call_id' => 'required|string',
            'signal_type' => 'required|in:offer,answer,ice-candidate,test',
            'signal_data' => 'required'
        ]);

        $callId = $request->call_id;
        $signalType = $request->signal_type;
        $signalData = $request->signal_data;
        $senderId = Session::get('user_id');

        // Store signal in database
        $signal = CallSignal::create([
            'call_id' => $callId,
            'sender_id' => $senderId,
            'signal_type' => $signalType,
            'signal_data' => $signalData
        ]);

        \Log::info("Signal sent: {$signalType} for call {$callId} by user {$senderId}");

        return response()->json([
            'success' => true, 
            'signal_id' => $signal->id,
            'debug' => [
                'call_id' => $callId,
                'signal_type' => $signalType,
                'sender_id' => $senderId
            ]
        ]);
    }

    public function getSignals(Request $request, $callId)
    {
        $currentUserId = Session::get('user_id');

        // Get unprocessed signals for this call from other users
        $signals = CallSignal::forCall($callId)
            ->notFromSender($currentUserId)
            ->unprocessed()
            ->orderBy('created_at')
            ->get();

        // Format signals and mark as processed
        $formattedSignals = [];
        foreach ($signals as $signal) {
            $formattedSignals[] = [
                'sender_id' => $signal->sender_id,
                'type' => $signal->signal_type,
                'data' => $signal->signal_data, // This is already an array due to casting
                'timestamp' => $signal->created_at->timestamp
            ];
            
            // Mark as processed
            $signal->markAsProcessed();
        }

        if (!empty($formattedSignals)) {
            \Log::info("Retrieved " . count($formattedSignals) . " signals for call {$callId} for user {$currentUserId}");
        }

        return response()->json(['signals' => $formattedSignals]);
    }

    public function pollSignals(Request $request, $callId)
    {
        $timeout = 30; // 30 seconds timeout
        $start = time();
        
        while (time() - $start < $timeout) {
            $response = $this->getSignals($request, $callId);
            $data = json_decode($response->getContent(), true);
            
            if (!empty($data['signals'])) {
                return response()->json($data);
            }
            
            usleep(500000); // Sleep 0.5 seconds
        }
        
        return response()->json(['signals' => []]);
    }
}