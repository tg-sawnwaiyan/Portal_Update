<div style="width:800px;">
<div >
	        <div style="padding: 60px;">

                <div style="text-align:center;"><span style="font-size: 40px;font-weight: bold;color: #d2571c;text-shadow: 3px 4px #ccc;text-align:center">LOGO <span style="font-size: 30px; color: #f57e46;">HERE</span></span></div>

	            <h5 style="color:#3e4348;font-size: 12px;margin-bottom: 30px;font-weight: bold;text-align: left;">
                    <p style="margin-top:10px;">医療介護ポータルより資料請求がございました。</p>                    
	            </h5>
                <p style="text-align: left;margin: 0px;">
                ***********************************************************************************************************************************
                </p>
                <p style="text-align:left;margin:2px;color:#3e4348;font-size: 16px;"><span style="color:#d2571c">◎</span>【資料請求先】</p>
                @foreach($getComment->fav_name_copy as $name)
              
                    @if($name != null)
                      <label> {{$name}}</label><br/>
                    @endif

                @endforeach
                
                <p style="text-align: left;margin: 0px;">
                ***********************************************************************************************************************************
                </p>
                <p style="text-align:left;margin:2px;color:#3e4348;font-size: 16px;"><span style="color:#d2571c">◎</span>【資料請求された方について】</p>
                <p style="text-align:left;margin:2px;color:#3e4348;font-size: 12px;">
                お名前：{{$getComment->name}}
                <br>
                ふりがな：{{$getComment->furigana}}
                <br>
                生年月日：{{$getComment->bdate}}
                <br>
                性別：{{$getComment->sex1}}
                <br>
                郵便番号：{{$getComment->postal}}
                <br>
                都道府県、市区町村、番地（建物名)：{{$getComment->division}}{{$getComment->townshipname}}{{$getComment->city}}
                <br>
                電話番号：{{$getComment->phone}}
                <br>
                メールアドレス：{{$getComment->mail}}
                </p> 
                <br>
                <p style="text-align:left;margin:2px;color:#3e4348;font-size: 16px;"><span style="color:#d2571c">◎</span>【入居対象者様について】</p>
                <p style="text-align:left;margin:2px;color:#3e4348;font-size: 12px;">
                入居対象者様とのご関係：{{$getComment->relation}}
                <br>
                お名前：{{$getComment->ttname}}
                <br>
                性別：{{$getComment->sex}}
                <br>
                年齢：{{$getComment->years}}
                <br>
                介護度：{{$getComment->nursing}}
                <br>
                認知症：{{$getComment->fect}}
                <br>
                ご要望や、お困りごと、その他お問い合わせ：{{$getComment->hope}}                    
                </p>
                <p style="text-align: left;margin: 0px;">
                ***********************************************************************************************************************************</p>   
                <p style="font-size:12px;color:#807c7c;text-align:left;"> 
                    <span style="color:#000">[医療介護ポータル] </span>
                    <br/>
                    〒163-0713
                    <br/>                        
                    東京都新宿区西新宿2-7-1小田急第一生命ビル13階 
                    <br/>                       
                    TEL：03-6911-???? FAX：03-6911-????
                </p>	       
	        </div>
	    </div>
</div>
  


  



