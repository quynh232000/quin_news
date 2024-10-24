<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Đổi mật khẩu</title>

</head>

<body>
    
    <div class="body"
        style="background-color: #f9f9fb;padding:10px 14px 40px; display:flex;flex-direction:column ;align-items:center">
        <div class="logo" style="margin: 20px 0">
            <img width="94" src="https://quin.mr-quynh.com/assest/images/UNIDI_LOGO-FINAL%202.svg" alt="">
        </div>
        <div class="content"
            style="background-color: white; border-radius:5px;padding:30px ;max-width:570px;color:rgb(61, 60, 60);margin:0 auto">
            <div class="title" style="font-weight: bold; font-size:20px">Đặt lại mật khẩu</div>
            <div class="subtitle" style="margin: 18px 0">
                Chúng tôi đã nhận được yêu cầu thay đổi mật khẩu cho tài khoản trên Quin News của bạn <span class="email"
                    style="text-decoration: underline;color:blue">
                    {{ $data['user']['email'] }}</span>
            </div>
            <div class="text-2">
                Nếu bạn không yêu cầu thay đổi mật khẩu, thì bạn có thể bỏ qua email này và mật khẩu của bạn sẽ không bị
                thay đổi. Liên kết dưới đây sẽ vẫn hoạt động trong 10 giờ.
            </div>
            <div class="btn-wrapper " style="justify-content: center;display:flex;padding:18px 0">
                <a href="{{ $data['url'] }}"
                    style="background-color: blue;color:white; border-radius:20px; padding:10px 40px;text-decoration:none;margin:auto">Đặt lại mật
                    khẩu</a>
            </div>
            <div class="footer" style="border-top: 1px solid rgba(22,22,24,.12);padding-top:18px">
                <div class="margin:0 auto 14px;text-align:center">Email được gởi tự động từ hệ thống. Vui lòng không phản hồi</div>
                <div class="margin:0 auto;text-align:center">Copyright © 2024 Quin News - All rights reserved.</div>
            </div>
        </div>
    </div>
</body>

</html>
