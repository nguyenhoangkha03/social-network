Table user {
  id_user int [pk]
  username varchar(200)
  password varchar(200)
  hoten varchar(200)
  diachi varchar(200)
  gioitinh int
  hinhanh longblob
  ngaytao timestamp
  ngaycapnhat timestamp
  email varchar(200)
  sodienthoai int
  trangthai boolean
}

Table baiviet {
  id_baiviet char(10) [pk]
  id_user int [ref: > user.id_user]
  tieude varchar(255)
  mota text
  noidung text
  anh_bia varchar(255)
  dinhkhem varchar(255)
  thoigiandang timestamp
  thoigiancapnhat timestamp
  soluotlike int
}

Table binhluan {
  id_binhluan int [pk, increment]
  id_user int [ref: > user.id_user]
  id_baiviet char(10) [ref: > baiviet.id_baiviet]
  noidung text
  thoigiantao timestamp
}

Table bai_viet_like {
  id_user int [ref: > user.id_user]
  id_baiviet char(10) [ref: > baiviet.id_baiviet]
  primary key (id_user, id_baiviet)
}

Table chanel {
  id_chanel int [pk]
  tenkenh varchar(200)
  nguoisohuu int [ref: > user.id_user]
  hinhanh_avatar longblob
  hinhanh_cover longblob
  thoigiantao timestamp
  thoigiancapnhat timestamp
  loaikenh int
}

Table chanel_block {
  id_chanel_block int [pk]
  id_user int [ref: > user.id_user]
  id_chanel int [ref: > chanel.id_chanel]
  taoluc timestamp
  capnhatluc timestamp
}

Table trangthaiuser {
  id_user int [pk, ref: > user.id_user]
  id_trangthai int
  ip_address varchar(255)
  user_agent text
  payload text
  last_activity int
}

Table tinnhan {
  id_tinnhan int [pk]
  id_user int [ref: > user.id_user]
  id_chanel int [ref: > chanel.id_chanel]
  noidung text
  thoigiantao timestamp
  thoigiancapnhat timestamp
  trangthaixoa varchar(255)
}

Table user_chanel {
  id_user int [ref: > user.id_user]
  id_chanel int [ref: > chanel.id_chanel]
  primary key (id_user, id_chanel)
}

Table danhsachbanbe {
  user_id_1 int [ref: > user.id_user]
  user_id_2 int [ref: > user.id_user]
  thoigianketban timestamp
  primary key (user_id_1, user_id_2)

  Rule: user_id_1 < user_id_2
}
