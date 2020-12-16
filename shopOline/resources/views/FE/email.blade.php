<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Email</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body style="margin: 0; padding: 0;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%"> 
        <tr>
            <td style="padding: 10px 0 30px 0;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;">
                    <tr>
                        <td bgcolor="#ffffff" style="padding: 40px 30px 10px 30px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
                                        <b>Cảm ơn Anh/Chị đã tin tưởng mua hàng tại Tums</b>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;border-bottom: 1px solid #000">
                                        Đơn hàng của Anh/chị đã được tiếp nhận, chúng tôi sẽ nhanh chóng liên hệ với Anh/Chị.
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <td width="260" valign="top">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td>
                                                                <h2 style="font-family: Arial, sans-serif;"><b>Thông tin khách hàng</b></h2>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                                                <p>{{ $user->full_name }}</p> 
                                                                <p>{{ $user->phone }}</p>
                                                                <p>{{ $user->email }}</p>
                                                                <p>{{ $user->address }}, {{ $user->district }}, {{ $user->provincial }}</p>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td style="font-size: 0; line-height: 0;" width="20">
                                                    &nbsp;
                                                </td>
                                                <td width="260" valign="top">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td>
                                                                <h2 style="font-family: Arial, sans-serif;"><b>Địa chỉ nhận hàng</b></h2>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                                                <p>{{ $user->full_name }}</p> 
                                                                <p>{{ $user->phone }}</p>
                                                                <p>{{ $user->address }}, {{ $user->district }},  {{ $user->provincial }}</p>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="border-bottom: 1px solid; padding-bottom: 30px">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <td width="260" valign="top">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td>
                                                                <h3 style="font-family: Arial, sans-serif;"><b>Hình thức thanh toán</b></h3>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                                                <span>Thanh toán khi giao hàng (COD)</span>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td style="font-size: 0; line-height: 0;" width="20">
                                                    &nbsp;
                                                </td>
                                                <td width="260" valign="top" >
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td>
                                                                <h3 style="font-family: Arial, sans-serif;"><b>Hình thức vận chuyển</b></h3>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="font-family: Arial, sans-serif; font-size: 16px;">
                                                                <span>Giao hàng tận nơi</span>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <tr>
                        <td style="padding: 0px 30px 40px 30px; color: #153643; font-family: Arial, sans-serif;">
                            <h5>Thông tin đơn hàng</h5>
                            <h5>Ngày đặt {{ date('Y-m-d') }}</h5>
                            <table width="100%">
                                <thead>
                                    <tr>
                                        <th colspan="2" style="text-align: center">Sản phẩm</th>
                                        <th style="text-align: center">Số lượng</th>
                                        <th style="text-align: center">Đơn giá</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        @php
                                            $total_price = 0;	
                                        @endphp

                                        @foreach($cart as $key => $item)
                                            <tr>
                                                <td style="width: 10%">
                                                    <img style="width: 100%" src="{{ $message->embed($item->options->img) }}">
                                                </td>
                    
                                                <td id="name">
                                                    <p>{{ $item->name }}</p>
                                                    @foreach($sizes as $key => $size)
                                                            @if($item->options->size == $size->id_size)
                                                                <span>{{ $size->size }} </span>,
                                                            @endif
                                                        @endforeach
                                                            
                                                        @foreach($colors as $key => $color)
                                                            @if($item->options->color == $color->id_color)
                                                                <span>{{ $color->color }} </span>
                                                            @endif
                                                        @endforeach
                                                </td>
                                                <td style="text-align: center">
                                                    {{ $item->qty }}
                                                </td>
                                                <td style="text-align: center">
                                                    {{ number_format($item->price*$item->qty,0,',','.')  }} đ
                                                </td>
                                            </tr>

                                            @php
                                                $total_price +=$item->price*$item->qty;	
                                            @endphp
                                        @endforeach
                                    </tr>

                                    <tr style="text-align: right;">
                                        <td colspan="3"><b style="font-size: 25px">Tổng cộng </b></td>
                                        
                                        <td style="text-align: center">
                                            {{ number_format($total_price,0,',','.') }} đ
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td bgcolor="#000" style="padding: 30px 30px 30px 30px;">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>