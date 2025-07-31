<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Về chúng tôi - ChatPost</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --primary-light: #dbeafe;
            --secondary: #64748b;
            --success: #10b981;
            --warning: #f59e0b;
            --error: #ef4444;
            --surface: #ffffff;
            --surface-secondary: #f8fafc;
            --surface-tertiary: #f1f5f9;
            --border: #e2e8f0;
            --border-light: #f1f5f9;
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --text-tertiary: #94a3b8;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
            --radius-sm: 0.375rem;
            --radius-md: 0.5rem;
            --radius-lg: 0.75rem;
            --radius-xl: 1rem;
            --radius-2xl: 1.5rem;
            --space-1: 0.25rem;
            --space-2: 0.5rem;
            --space-3: 0.75rem;
            --space-4: 1rem;
            --space-5: 1.25rem;
            --space-6: 1.5rem;
            --space-8: 2rem;
            --space-10: 2.5rem;
            --space-12: 3rem;
            --space-16: 4rem;
            --space-20: 5rem;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: var(--text-primary);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: var(--space-6);
        }

        .header {
            background: var(--surface);
            border-radius: var(--radius-2xl);
            box-shadow: var(--shadow-xl);
            padding: var(--space-8);
            margin-bottom: var(--space-8);
            text-align: center;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: var(--space-2);
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            margin-bottom: var(--space-6);
            padding: var(--space-2) var(--space-4);
            background: var(--surface-secondary);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border-light);
            transition: all 0.2s ease;
            font-size: 0.875rem;
        }

        .back-btn:hover {
            background: var(--primary-light);
            color: var(--primary-dark);
            transform: translateX(-2px);
            box-shadow: var(--shadow-sm);
        }

        .page-title {
            font-size: 3rem;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: var(--space-4);
            background: linear-gradient(135deg, var(--primary), #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .page-subtitle {
            font-size: 1.25rem;
            color: var(--text-secondary);
            max-width: 700px;
            margin: 0 auto;
        }

        .content-grid {
            display: grid;
            gap: var(--space-8);
        }

        .section {
            background: var(--surface);
            border-radius: var(--radius-2xl);
            box-shadow: var(--shadow-xl);
            padding: var(--space-8);
            overflow: hidden;
        }

        .section-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: var(--space-6);
            display: flex;
            align-items: center;
            gap: var(--space-3);
        }

        .section-title i {
            color: var(--primary);
        }

        .section-content {
            font-size: 1.125rem;
            line-height: 1.8;
            color: var(--text-secondary);
        }

        .section-content p {
            margin-bottom: var(--space-4);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: var(--space-6);
            margin: var(--space-8) 0;
        }

        .stat-card {
            text-align: center;
            padding: var(--space-6);
            background: var(--surface-secondary);
            border-radius: var(--radius-xl);
            border: 1px solid var(--border-light);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
            background: var(--surface);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: var(--radius-xl);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto var(--space-4);
            font-size: 1.5rem;
            color: white;
        }

        .stat-icon.users {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        }

        .stat-icon.posts {
            background: linear-gradient(135deg, #10b981, #059669);
        }

        .stat-icon.categories {
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        }

        .stat-icon.likes {
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: var(--space-2);
        }

        .stat-label {
            color: var(--text-secondary);
            font-weight: 600;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: var(--space-6);
            margin-top: var(--space-8);
        }

        .feature-card {
            padding: var(--space-6);
            background: var(--surface-secondary);
            border-radius: var(--radius-xl);
            border: 1px solid var(--border-light);
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            background: var(--surface);
        }

        .feature-icon {
            width: 50px;
            height: 50px;
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: var(--space-4);
            font-size: 1.25rem;
            color: white;
        }

        .feature-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: var(--space-3);
        }

        .feature-desc {
            color: var(--text-secondary);
            line-height: 1.6;
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: var(--space-6);
            margin-top: var(--space-8);
        }

        .team-member {
            text-align: center;
            padding: var(--space-6);
            background: var(--surface-secondary);
            border-radius: var(--radius-xl);
            border: 1px solid var(--border-light);
            transition: all 0.3s ease;
        }

        .team-member:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
            background: var(--surface);
        }

        .member-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), #8b5cf6);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            font-weight: 700;
            margin: 0 auto var(--space-4);
        }

        .member-name {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: var(--space-2);
        }

        .member-role {
            color: var(--primary);
            font-weight: 600;
            margin-bottom: var(--space-3);
        }

        .member-desc {
            color: var(--text-secondary);
            font-size: 0.875rem;
            line-height: 1.6;
        }

        .contact-section {
            background: linear-gradient(135deg, var(--primary), #8b5cf6);
            color: white;
            text-align: center;
        }

        .contact-section .section-title {
            color: white;
        }

        .contact-section .section-title i {
            color: rgba(255, 255, 255, 0.8);
        }

        .contact-content {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.125rem;
            margin-bottom: var(--space-6);
        }

        .contact-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: var(--space-6);
            margin-top: var(--space-8);
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            padding: var(--space-4);
            background: rgba(255, 255, 255, 0.1);
            border-radius: var(--radius-lg);
            backdrop-filter: blur(10px);
        }

        .contact-icon {
            width: 40px;
            height: 40px;
            border-radius: var(--radius-lg);
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .btn {
            padding: var(--space-3) var(--space-6);
            border-radius: var(--radius-lg);
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: var(--space-2);
            font-size: 0.875rem;
            text-decoration: none;
        }

        .btn-white {
            background: white;
            color: var(--primary);
        }

        .btn-white:hover {
            background: var(--surface-secondary);
            transform: translateY(-1px);
            box-shadow: var(--shadow-lg);
        }

        @media (max-width: 768px) {
            .container {
                padding: var(--space-4);
            }

            .page-title {
                font-size: 2rem;
            }

            .section {
                padding: var(--space-6);
            }

            .section-title {
                font-size: 1.5rem;
            }

            .section-content {
                font-size: 1rem;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .features-grid,
            .team-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <a href="{{ route('home') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i>
                Quay lại trang chủ
            </a>
            
            <h1 class="page-title">Về ChatPost</h1>
            <p class="page-subtitle">
                Nền tảng chia sẻ kiến thức và kết nối cộng đồng hàng đầu Việt Nam. 
                Nơi mọi ý tưởng đều có giá trị và được tôn trọng.
            </p>
        </div>

        <div class="content-grid">
            <!-- Mission Section -->
            <div class="section">
                <h2 class="section-title">
                    <i class="fas fa-bullseye"></i>
                    Sứ mệnh của chúng tôi
                </h2>
                <div class="section-content">
                    <p>
                        ChatPost được sinh ra với sứ mệnh tạo nên một không gian trực tuyến nơi mà kiến thức được chia sẻ tự do, 
                        những ý tưởng sáng tạo được truyền cảm hứng, và mọi người có thể kết nối với nhau thông qua đam mê chung.
                    </p>
                    <p>
                        Chúng tôi tin rằng mỗi người đều có những câu chuyện đáng kể, những kiến thức quý báu để chia sẻ. 
                        ChatPost là cầu nối giúp những câu chuyện đó đến với những người cần nghe, tạo nên một cộng đồng 
                        học hỏi và phát triển bền vững.
                    </p>
                </div>

                <!-- Stats -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon users">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-number">{{ number_format($stats['users']) }}</div>
                        <div class="stat-label">Thành viên</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon posts">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <div class="stat-number">{{ number_format($stats['posts']) }}</div>
                        <div class="stat-label">Bài viết</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon categories">
                            <i class="fas fa-tags"></i>
                        </div>
                        <div class="stat-number">{{ number_format($stats['categories']) }}</div>
                        <div class="stat-label">Chủ đề</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon likes">
                            <i class="fas fa-heart"></i>
                        </div>
                        <div class="stat-number">{{ number_format($stats['total_likes']) }}</div>
                        <div class="stat-label">Lượt yêu thích</div>
                    </div>
                </div>
            </div>

            <!-- Features Section -->
            <div class="section">
                <h2 class="section-title">
                    <i class="fas fa-star"></i>
                    Tính năng nổi bật
                </h2>
                <div class="section-content">
                    <p>ChatPost được thiết kế với những tính năng hiện đại, tập trung vào trải nghiệm người dùng tối ưu:</p>
                </div>

                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8);">
                            <i class="fas fa-edit"></i>
                        </div>
                        <div class="feature-title">Soạn thảo thông minh</div>
                        <p class="feature-desc">
                            Trình soạn thảo WYSIWYG hiện đại với khả năng tải lên hình ảnh, 
                            định dạng văn bản phong phú và xem trước thời gian thực.
                        </p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon" style="background: linear-gradient(135deg, #10b981, #059669);">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="feature-title">Cộng đồng sôi động</div>
                        <p class="feature-desc">
                            Kết nối với hàng nghìn thành viên, theo dõi những tác giả yêu thích, 
                            và tham gia vào các cuộc thảo luận sôi nổi.
                        </p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
                            <i class="fas fa-search"></i>
                        </div>
                        <div class="feature-title">Tìm kiếm thông minh</div>
                        <p class="feature-desc">
                            Hệ thống tìm kiếm mạnh mẽ giúp bạn dễ dàng tìm thấy nội dung, 
                            người dùng và chủ đề quan tâm chỉ trong vài giây.
                        </p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon" style="background: linear-gradient(135deg, #ef4444, #dc2626);">
                            <i class="fas fa-comments"></i>
                        </div>
                        <div class="feature-title">Tin nhắn trực tiếp</div>
                        <p class="feature-desc">
                            Trò chuyện trực tiếp với bạn bè và đồng nghiệp thông qua 
                            hệ thống tin nhắn thời gian thực hiện đại.
                        </p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                            <i class="fas fa-palette"></i>
                        </div>
                        <div class="feature-title">Giao diện tùy chỉnh</div>
                        <p class="feature-desc">
                            Chế độ tối/sáng, tùy chỉnh ngôn ngữ và nhiều tùy chọn 
                            cá nhân hóa khác cho trải nghiệm tối ưu.
                        </p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon" style="background: linear-gradient(135deg, #06b6d4, #0891b2);">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="feature-title">Responsive Design</div>
                        <p class="feature-desc">
                            Giao diện thích ứng hoàn hảo trên mọi thiết bị, 
                            từ desktop đến tablet và smartphone.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Team Section -->
            <div class="section">
                <h2 class="section-title">
                    <i class="fas fa-heart"></i>
                    Đội ngũ phát triển
                </h2>
                <div class="section-content">
                    <p>ChatPost được phát triển bởi đội ngũ đam mê công nghệ và mong muốn tạo ra những sản phẩm có ý nghĩa:</p>
                </div>

                <div class="team-grid">
                    <div class="team-member">
                        <div class="member-avatar">
                            <i class="fas fa-code"></i>
                        </div>
                        <div class="member-name">Nguyễn Văn A</div>
                        <div class="member-role">Lead Developer</div>
                        <p class="member-desc">
                            10+ năm kinh nghiệm phát triển web, chuyên về Laravel và React. 
                            Đam mê tạo ra những sản phẩm công nghệ có tác động tích cực.
                        </p>
                    </div>

                    <div class="team-member">
                        <div class="member-avatar">
                            <i class="fas fa-paint-brush"></i>
                        </div>
                        <div class="member-name">Trần Thị B</div>
                        <div class="member-role">UI/UX Designer</div>
                        <p class="member-desc">
                            Chuyên gia thiết kế giao diện với 8 năm kinh nghiệm. 
                            Tin rằng thiết kế tốt có thể thay đổi cách con người tương tác với công nghệ.
                        </p>
                    </div>

                    <div class="team-member">
                        <div class="member-avatar">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="member-name">Lê Văn C</div>
                        <div class="member-role">Product Manager</div>
                        <p class="member-desc">
                            Chuyên gia quản lý sản phẩm với tầm nhìn chiến lược. 
                            Luôn lắng nghe người dùng và biến ý tưởng thành hiện thực.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Contact Section -->
            <div class="section contact-section">
                <h2 class="section-title">
                    <i class="fas fa-envelope"></i>
                    Liên hệ với chúng tôi
                </h2>
                <div class="contact-content">
                    <p>
                        Chúng tôi luôn sẵn sàng lắng nghe ý kiến đóng góp và hỗ trợ cộng đồng. 
                        Hãy liên hệ với chúng tôi qua các kênh sau:
                    </p>
                </div>

                <div class="contact-info">
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <div style="font-weight: 600; margin-bottom: var(--space-1);">Email</div>
                            <div>contact@chatpost.vn</div>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div>
                            <div style="font-weight: 600; margin-bottom: var(--space-1);">Hotline</div>
                            <div>1900 xxxx</div>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <div style="font-weight: 600; margin-bottom: var(--space-1);">Địa chỉ</div>
                            <div>Hà Nội, Việt Nam</div>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fab fa-facebook"></i>
                        </div>
                        <div>
                            <div style="font-weight: 600; margin-bottom: var(--space-1);">Facebook</div>
                            <div>fb.com/chatpost</div>
                        </div>
                    </div>
                </div>

                <div style="margin-top: var(--space-8);">
                    @if(!$user)
                        <a href="{{ route('register') }}" class="btn btn-white">
                            <i class="fas fa-user-plus"></i>
                            Tham gia cộng đồng
                        </a>
                    @else
                        <a href="{{ route('post.create') }}" class="btn btn-white">
                            <i class="fas fa-plus"></i>
                            Tạo bài viết đầu tiên
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>