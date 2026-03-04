<?php
define('API_KEY', getenv('BOT_TOKEN'));

$admin = "7979780050";

function bot($method,$datas=[]){
$url = "https://api.telegram.org/bot".API_KEY."/".$method;
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
$res = curl_exec($ch);
if(curl_error($ch)){
var_dump(curl_error($ch));
}else{
return json_decode($res);
}}

function deleteFolder($path){
if(is_dir($path) === true){
$files = array_diff(scandir($path), array('.', '..'));
foreach ($files as $file)
deleteFolder(realpath($path) . '/' . $file);
return rmdir($path);
}else if (is_file($path) === true)
return unlink($path);
return false;
}

function joinchat($id){
global $mid;
$array = array("inline_keyboard");
$kanallar=file_get_contents("channel.txt");
if($kanallar == null){
return true;
}else{
$ex = explode("\n",$kanallar);
for($i=0;$i<=count($ex) -1;$i++){
$first_line = $ex[$i];
$first_ex = explode("@",$first_line);
$url = $first_ex[1];
$ism=bot('getChat',['chat_id'=>"@".$url,])->result->title;
$ret = bot("getChatMember",[
"chat_id"=>"@$url",
"user_id"=>$id,
]);
$stat = $ret->result->status;
if((($stat=="creator" or $stat=="administrator" or $stat=="member"))){
$array['inline_keyboard']["$i"][0]['text'] = "✅ ". $ism;
$array['inline_keyboard']["$i"][0]['url'] = "https://t.me/$url";
}else{
$array['inline_keyboard']["$i"][0]['text'] = "❌ ". $ism;
$array['inline_keyboard']["$i"][0]['url'] = "https://t.me/$url";
$uns = true;
}
}
$array['inline_keyboard']["$i"][0]['text'] = "🔄 Tekshirish";
$array['inline_keyboard']["$i"][0]['callback_data'] = "azo_boldim";
if($uns == true){
bot('sendMessage',[
'chat_id'=>$id,
'text'=>"<b>⚠️ Botdan to'liq foydalanish uchun quyidagi kanallarimizga obuna bo'ling!</b>",
'parse_mode'=>'html',
'disable_web_page_preview'=>true,
'reply_markup'=>json_encode($array),
]);
return false;
}else{
return true;
}}}

$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$cid = $message->chat->id;
$tx = $message->text;
$mid = $message->message_id;
$name = $message->from->first_name;
$fid = $message->from->id;
$callback = $update->callback_query;
$data = $callback->data;
$callid = $callback->id;
$ccid = $callback->message->chat->id;
$cmid = $callback->message->message_id;
$from_id = $update->message->from->id;
$token = $message->text;
$text = $message->text;
$name = $message->from->first_name;
$message_id = $callback->message->message_id;
$data = $update->callback_query->data;
$callcid=$update->callback_query->message->chat->id;
$cqid = $update->callback_query->id;
$callfrid = $update->callback_query->from->id;
$botname = bot('getme',['bot'])->result->username;
#-----------------------------
mkdir("statistika");
mkdir("step");
mkdir("ban");
#-----------------------------

if(!file_exists("channel.txt")){
file_put_contents("channel.txt","");
}
if(file_get_contents("statistika/obunachi.txt")){
} else{
file_put_contents("statistika/obunachi.txt", "0");
}

$saved = file_get_contents("step/odam.txt");
$ban = file_get_contents("ban/$fid.txt");
$statistika = file_get_contents("statistika/obunachi.txt");
$soat=date("H:i",strtotime("2 hour"));
$userstep=file_get_contents("step/$fid.txt");
$kanallar=file_get_contents("channel.txt");

if($tx){
if($ban == "ban"){
exit();
}else{
}}

if($data){
$ban = file_get_contents("ban/$ccid.txt");
if($ban == "ban"){
exit();
}else{
}}

if(isset($callback)){
$get = file_get_contents("statistika/obunachi.txt");
if(mb_stripos($get,$callfrid)==false){
file_put_contents("statistika/obunachi.txt", "$get\n$callfrid");
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>👤 Yangi obunachi botga qo'shildi!</b>",
'parse_mode'=>"html"
]);
}}

if(isset($message)){
$get = file_get_contents("statistika/obunachi.txt");
if(mb_stripos($get,$fid)==false){
file_put_contents("statistika/obunachi.txt", "$get\n$fid");
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>👤 Yangi obunachi botga qo'shildi!</b>",
'parse_mode'=>"html"
]);
}}

if($tx=="/start" and joinchat($cid)=="true"){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>💟 Assalomu alaykum xurmatli foydalanuvchi botimizga xush kelibsiz:</b>

Siz ushbu bot bilan juda ko'p imkoniyatlarga egasiz, agarda xatoliklar bo'lsa admin bilan bog'laning!",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"📸 Photo bo'limi",'callback_data'=>"photos"],['text'=>"💛 Video yasash",'callback_data'=>"videolar"]],
[['text'=>"📝 Chiroyli niklar",'callback_data'=>"niklar"],['text'=>"🔉 Kulguli ovoz",'callback_data'=>"kulguli"]],
[['text'=>"❤️ Animatsiyalar",'callback_data'=>"animatsa"],['text'=>"🌉 Yangi fonlar",'callback_data'=>"fonlar"]],
[['text'=>"💷 Valyuta kursi",'callback_data'=>"valyuta"],['text'=>"🌟 Botni baholash",'callback_data'=>"botbahola"]],
[['text'=>"🪐 Foydali bo'lim",'callback_data'=>"foydali"],['text'=>"💌 Adminga xabar",'callback_data'=>"boglanish"]],
]])
]);
unlink("step/$cid.txt");
unlink("fbsh.txt");
}

if($data == "azo_boldim"){
if(joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>💟 Assalomu alaykum xurmatli foydalanuvchi botimizga xush kelibsiz:</b>

Siz ushbu bot bilan juda ko'p imkoniyatlarga egasiz, agarda xatoliklar bo'lsa admin bilan bog'laning!",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"📸 Photo bo'limi",'callback_data'=>"photos"],['text'=>"💛 Video yasash",'callback_data'=>"videolar"]],
[['text'=>"📝 Chiroyli niklar",'callback_data'=>"niklar"],['text'=>"🔉 Kulguli ovoz",'callback_data'=>"kulguli"]],
[['text'=>"❤️ Animatsiyalar",'callback_data'=>"animatsa"],['text'=>"🌉 Yangi fonlar",'callback_data'=>"fonlar"]],
[['text'=>"💷 Valyuta kursi",'callback_data'=>"valyuta"],['text'=>"🌟 Botni baholash",'callback_data'=>"botbahola"]],
[['text'=>"🪐 Foydali bo'lim",'callback_data'=>"foydali"],['text'=>"💌 Adminga xabar",'callback_data'=>"boglanish"]],
]])
]);
}else{
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
}}

if($data == "menyu" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>💟 Assalomu alaykum xurmatli foydalanuvchi botimizga xush kelibsiz:</b>

Siz ushbu bot bilan juda ko'p imkoniyatlarga egasiz, agarda xatoliklar bo'lsa admin bilan bog'laning!",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"📸 Photo bo'limi",'callback_data'=>"photos"],['text'=>"💛 Video yasash",'callback_data'=>"videolar"]],
[['text'=>"📝 Chiroyli niklar",'callback_data'=>"niklar"],['text'=>"🔉 Kulguli ovoz",'callback_data'=>"kulguli"]],
[['text'=>"❤️ Animatsiyalar",'callback_data'=>"animatsa"],['text'=>"🌉 Yangi fonlar",'callback_data'=>"fonlar"]],
[['text'=>"💷 Valyuta kursi",'callback_data'=>"valyuta"],['text'=>"🌟 Botni baholash",'callback_data'=>"botbahola"]],
[['text'=>"🪐 Foydali bo'lim",'callback_data'=>"foydali"],['text'=>"💌 Adminga xabar",'callback_data'=>"boglanish"]],
]])
]);
unlink("step/$ccid.txt");
}

if($data == "photos" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>🌉 Rasm yasash bo’limiga xush kelibsiz!</b>

Quyidagilardan birini tanlang:",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🎉 Yangi Yil uchun",'callback_data'=>"yangiyil"]],
[['text'=>"🧔🏻‍♂ Yigitlar uchun",'callback_data'=>"yigitlar"],['text'=>"👱🏼‍♀ Ayollar uchun",'callback_data'=>"ayollar"]],
[['text'=>"☪ Juma tabrigi",'callback_data'=>"juma"],['text'=>"🌹 8-Mart uchun",'callback_data'=>"8mart"]],
[['text'=>"📝 QR Kod yasash",'callback_data'=>"qryasa"],['text'=>"❌ Ortga Qaytish",'callback_data'=>"menyu"]],
]])
]);
}

if($data == "yangiyil" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendphoto',[
'chat_id'=>$ccid,
'photo'=>"https://t.me/botim1chi/445",
'caption'=>"<b>🎉 Yangi Yil uchun rasmlar bo'limiga xush kelibsiz!</b>

Quyidagilardan birini tanlang:",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"1⃣",'callback_data'=>"yangi-1"],['text'=>"2⃣",'callback_data'=>"yangi-2"],['text'=>"3⃣",'callback_data'=>"yangi-3"]],
[['text'=>"4⃣",'callback_data'=>"yangi-4"],['text'=>"5⃣",'callback_data'=>"yangi-5"],['text'=>"6⃣",'callback_data'=>"yangi-6"]],
[['text'=>"7⃣",'callback_data'=>"yangi-7"],['text'=>"8⃣",'callback_data'=>"yangi-8"],['text'=>"9⃣",'callback_data'=>"yangi-9"]],
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"photos"]],
]])
]);
}

if(mb_stripos($data, "yangi-")!==false){
$ex = explode("-",$data);
$son = $ex[1];
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>📝 Ismingizni yuboring:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"yangiyil"]],
]])
]);
file_put_contents("step/$ccid.txt","yangiyilga-$son");
}
if(mb_stripos($userstep, "yangiyilga-")!==false){
$ex = explode("-",$userstep);
$son = $ex[1];
bot('sendphoto',[
'chat_id'=>$cid,
'photo'=>"https://rcbuilder.ga/YangiYil/New$son/api.php?text=$text",
'caption'=>"<b>🌟 Ismingizga rasm tayyorlandi!

📝 Yozilgan ism:</b><code> $text </code>

<b>📲 Do’stlarga ham ulashing 💫</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"💌 Do'stlarga ulashish 🔗",'url'=>"https://t.me/share/url?url=https://t.me/$botname"]],
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"photos"]],
]])
]);
unlink("step/$cid.txt");
}

if($data == "yigitlar" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendphoto',[
'chat_id'=>$ccid,
'photo'=>"https://t.me/botim1chi/446",
'caption'=>"<b>🧔🏻‍♂ Yigitlar uchun rasm yasash bo'limiga xush kelibsiz!</b>

Quyidagilardan birini tanlang:",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"1⃣",'callback_data'=>"yigit-01"],['text'=>"2⃣",'callback_data'=>"yigit-02"],['text'=>"3⃣",'callback_data'=>"yigit-03"]],
[['text'=>"4⃣",'callback_data'=>"yigit-04"],['text'=>"5⃣",'callback_data'=>"yigit-05"],['text'=>"6⃣",'callback_data'=>"yigit-06"]],
[['text'=>"7⃣",'callback_data'=>"yigit-07"],['text'=>"8⃣",'callback_data'=>"yigit-08"],['text'=>"9⃣",'callback_data'=>"yigit-09"]],
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"photos"]],
]])
]);
}

if(mb_stripos($data, "yigit-")!==false){
$ex = explode("-",$data);
$son = $ex[1];
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>📝 Ismingizni yuboring:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"yigitlar"]],
]])
]);
file_put_contents("step/$ccid.txt","yigitlar-$son");
}
if(mb_stripos($userstep, "yigitlar-")!==false){
$ex = explode("-",$userstep);
$son = $ex[1];
bot('sendphoto',[
'chat_id'=>$cid,
'photo'=>"https://rcbuilder.ga/Yigitlar/Yigitlar$son/api.php?text=$text",
'caption'=>"<b>🌟 Ismingizga rasm tayyorlandi!

📝 Yozilgan ism:</b><code> $text </code>

<b>📲 Do’stlarga ham ulashing 💫</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"💌 Do'stlarga ulashish 🔗",'url'=>"https://t.me/share/url?url=https://t.me/$botname"]],
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"photos"]],
]])
]);
unlink("step/$cid.txt");
}

if($data == "ayollar" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendphoto',[
'chat_id'=>$ccid,
'photo'=>"https://t.me/botim1chi/447",
'caption'=>"<b>👱🏼‍♀ Ayollar uchun rasm yasash bo'limiga xush kelibsiz!</b>

Quyidagilardan birini tanlang:",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"1⃣",'callback_data'=>"qiz-01"],['text'=>"2⃣",'callback_data'=>"qiz-02"],['text'=>"3⃣",'callback_data'=>"qiz-03"]],
[['text'=>"4⃣",'callback_data'=>"qiz-04"],['text'=>"5⃣",'callback_data'=>"qiz-05"],['text'=>"6⃣",'callback_data'=>"qiz-06"]],
[['text'=>"7⃣",'callback_data'=>"qiz-07"],['text'=>"8⃣",'callback_data'=>"qiz-08"],['text'=>"9⃣",'callback_data'=>"qiz-09"]],
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"photos"]],
]])
]);
}

if(mb_stripos($data, "qiz-")!==false){
$ex = explode("-",$data);
$son = $ex[1];
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>📝 Ismingizni yuboring:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"ayollar"]],
]])
]);
file_put_contents("step/$ccid.txt","ayollar-$son");
}
if(mb_stripos($userstep, "ayollar-")!==false){
$ex = explode("-",$userstep);
$son = $ex[1];
bot('sendphoto',[
'chat_id'=>$cid,
'photo'=>"https://rcbuilder.ga/Qizlar/Qizlar$son/api.php?text=$text",
'caption'=>"<b>🌟 Ismingizga rasm tayyorlandi!

📝 Yozilgan ism:</b><code> $text </code>

<b>📲 Do’stlarga ham ulashing 💫</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"💌 Do'stlarga ulashish 🔗",'url'=>"https://t.me/share/url?url=https://t.me/$botname"]],
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"photos"]],
]])
]);
unlink("step/$cid.txt");
}

if($data == "juma" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>📝 Ismingizni yuboring:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"photos"]],
]])
]);
file_put_contents("step/$ccid.txt","juma");
}
if($userstep == "juma"){
bot('sendphoto',[
'chat_id'=>$cid,
'photo'=>"https://rcbuilder.ga/juma/juma1/api.php?text=$text",
'caption'=>"<b>🌟 Ismingizga rasm tayyorlandi!

📝 Yozilgan ism:</b><code> $text </code>

<b>📲 Do’stlarga ham ulashing 💫</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"💌 Do'stlarga ulashish 🔗",'url'=>"https://t.me/share/url?url=https://t.me/$botname"]],
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"photos"]],
]])
]);
unlink("step/$cid.txt");
}

if($data == "8mart" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>📝 Ismingizni yuboring:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"photos"]],
]])
]);
file_put_contents("step/$ccid.txt","8mart");
}
if($userstep == "8mart"){
bot('sendphoto',[
'chat_id'=>$cid,
'photo'=>"https://rcbuilder.ga/mart/martuzb/api1.php?text=$text",
'caption'=>"<b>🌟 Ismingizga rasm tayyorlandi!

📝 Yozilgan ism:</b><code> $text </code>

<b>📲 Do’stlarga ham ulashing 💫</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"💌 Do'stlarga ulashish 🔗",'url'=>"https://t.me/share/url?url=https://t.me/$botname"]],
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"photos"]],
]])
]);
unlink("step/$cid.txt");
}

if($data == "qryasa" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>📝 Biron bir so'z yuboring:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"photos"]],
]])
]);
file_put_contents("step/$ccid.txt","qrcod");
}
if($userstep == "qrcod"){
bot('sendphoto',[
'chat_id'=>$cid,
'photo'=>"http://qr-code.ir/api/qr-code?s=5&e=M&t=P&d=$text",
'caption'=>"<b>🌟 QR Kod tayyorlandi!

📝 Yozilgan so'z:</b><code> $text </code>

<b>📲 Do’stlarga ham ulashing 💫</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"💌 Do'stlarga ulashish 🔗",'url'=>"https://t.me/share/url?url=https://t.me/$botname"]],
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"photos"]],
]])
]);
unlink("step/$cid.txt");
}

if($data == "niklar" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>📝 Chiroyli niklar bo'limiga xush kelibsiz!</b>

Ismingizni yuboring:",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"menyu"]],
]])
]);
file_put_contents("step/$ccid.txt",'nick');
}

if($userstep == "nick" and $tx !== "/start"){
if($data=="menyu"){
unlink("step/$cid.txt");
}else{
$nick1 = $tx;
$nick1 = str_replace('a', 'ᗩ', $nick1);
$nick1 = str_replace('b', 'ᗷ', $nick1);
$nick1 = str_replace('c', 'ᑕ', $nick1);
$nick1 = str_replace('d', 'ᗪ', $nick1);
$nick1 = str_replace('e', 'E', $nick1);
$nick1 = str_replace('f', 'ᖴ', $nick1);
$nick1 = str_replace('g', 'G', $nick1);
$nick1 = str_replace('h', 'ᕼ', $nick1);
$nick1 = str_replace('i', 'I', $nick1);
$nick1 = str_replace('j', 'ᒍ', $nick1);
$nick1 = str_replace('k', 'K', $nick1);
$nick1 = str_replace('l', 'ᒪ', $nick1);
$nick1 = str_replace('m', 'ᗰ', $nick1);
$nick1 = str_replace('n', 'ᑎ', $nick1);
$nick1 = str_replace('o', 'O', $nick1);
$nick1 = str_replace('p', 'ᑭ', $nick1);
$nick1 = str_replace('q', 'ᑫ', $nick1);
$nick1 = str_replace('r', 'ᖇ', $nick1);
$nick1 = str_replace('s', 'ᔕ', $nick1);
$nick1 = str_replace('t', 'T', $nick1);
$nick1 = str_replace('u', 'ᑌ', $nick1);
$nick1 = str_replace('v', 'ᐯ', $nick1);
$nick1 = str_replace('w', 'ᗯ', $nick1);
$nick1 = str_replace('x', '᙭', $nick1);
$nick1 = str_replace('y', 'Y', $nick1);
$nick1 = str_replace('z', 'ᘔ', $nick1); 

$nick1 = str_replace('A', 'ᗩ', $nick1);
$nick1 = str_replace('B', 'ᗷ', $nick1);
$nick1 = str_replace('C', 'ᑕ', $nick1);
$nick1 = str_replace('D', 'ᗪ', $nick1);
$nick1 = str_replace('E', 'E', $nick1);
$nick1 = str_replace('F', 'ᖴ', $nick1);
$nick1 = str_replace('G', 'G', $nick1);
$nick1 = str_replace('H', 'ᕼ', $nick1);
$nick1 = str_replace('I', 'I', $nick1);
$nick1 = str_replace('J', 'ᒍ', $nick1);
$nick1 = str_replace('K', 'K', $nick1);
$nick1 = str_replace('L', 'ᒪ', $nick1);
$nick1 = str_replace('M', 'ᗰ', $nick1);
$nick1 = str_replace('N', 'ᑎ', $nick1);
$nick1 = str_replace('O', 'O', $nick1);
$nick1 = str_replace('P', 'ᑭ', $nick1);
$nick1 = str_replace('Q', 'ᑫ', $nick1);
$nick1 = str_replace('R', 'ᖇ', $nick1);
$nick1 = str_replace('S', 'ᔕ', $nick1);
$nick1 = str_replace('T', 'T', $nick1);
$nick1 = str_replace('U', 'ᑌ', $nick1);
$nick1 = str_replace('V', 'ᐯ', $nick1);
$nick1 = str_replace('W', 'ᗯ', $nick1);
$nick1 = str_replace('X', '᙭', $nick1);
$nick1 = str_replace('Y', 'Y', $nick1);
$nick1 = str_replace('Z', 'ᘔ', $nick1);
#-------------------------------------#
$nick2 = $tx;
$nick2 = str_replace("q", "ⓠ", $nick2);
$nick2 = str_replace("w", "ⓦ", $nick2);
$nick2 = str_replace("e", "ⓔ", $nick2);
$nick2 = str_replace("r", "ⓡ", $nick2);
$nick2 = str_replace("t", "ⓣ", $nick2);
$nick2 = str_replace("y", "ⓨ", $nick2);
$nick2 = str_replace("u", "ⓤ", $nick2);
$nick2 = str_replace("i", "ⓘ", $nick2);
$nick2 = str_replace("o", "ⓞ", $nick2);
$nick2 = str_replace("p", "ⓟ", $nick2);
$nick2 = str_replace("a", "ⓐ", $nick2);
$nick2 = str_replace("s", "ⓢ", $nick2);
$nick2 = str_replace("d", "ⓓ", $nick2);
$nick2 = str_replace("f", "ⓕ", $nick2);
$nick2 = str_replace("g", "ⓖ", $nick2);
$nick2 = str_replace("h", "ⓗ", $nick2);
$nick2 = str_replace("j", "ⓙ", $nick2);
$nick2 = str_replace("k", "ⓚ", $nick2);
$nick2 = str_replace("l", "ⓛ", $nick2);
$nick2 = str_replace("z", "ⓩ", $nick2);
$nick2 = str_replace("x", "ⓧ", $nick2);
$nick2 = str_replace("c", "ⓒ", $nick2);
$nick2 = str_replace("v", "ⓥ", $nick2);
$nick2 = str_replace("b", "ⓑ", $nick2);
$nick2 = str_replace("n", "ⓝ", $nick2);
$nick2 = str_replace("m", "ⓜ", $nick2);

$nick2 = str_replace("Q", "Ⓠ", $nick2);
$nick2 = str_replace("W", "Ⓦ", $nick2);
$nick2 = str_replace("E", "Ⓔ", $nick2);
$nick2 = str_replace("R", "Ⓡ", $nick2);
$nick2 = str_replace("T", "Ⓣ", $nick2);
$nick2 = str_replace("Y", "Ⓨ", $nick2);
$nick2 = str_replace("U", "Ⓤ", $nick2);
$nick2 = str_replace("I", "Ⓘ", $nick2);
$nick2 = str_replace("O", "Ⓞ", $nick2);
$nick2 = str_replace("P", "Ⓟ", $nick2);
$nick2 = str_replace("A", "Ⓐ", $nick2);
$nick2 = str_replace("S", "Ⓢ", $nick2);
$nick2 = str_replace("D", "Ⓓ", $nick2);
$nick2 = str_replace("F", "Ⓕ", $nick2);
$nick2 = str_replace("G", "Ⓖ", $nick2);
$nick2 = str_replace("H", "Ⓗ", $nick2);
$nick2 = str_replace("J", "Ⓙ", $nick2);
$nick2 = str_replace("K", "Ⓚ", $nick2);
$nick2 = str_replace("L", "Ⓛ", $nick2);
$nick2 = str_replace("Z", "Ⓩ", $nick2);
$nick2 = str_replace("X", "Ⓧ", $nick2);
$nick2 = str_replace("C", "Ⓒ", $nick2);
$nick2 = str_replace("V", "Ⓥ", $nick2);
$nick2 = str_replace("B", "Ⓑ", $nick2);
$nick2 = str_replace("N", "Ⓝ", $nick2);
$nick2 = str_replace("M", "Ⓜ", $nick2);
#-------------------------------------#
$nick3 = $tx;
$nick3 = str_replace("q", "q҉", $nick3);
$nick3 = str_replace("w", "w҉", $nick3);
$nick3 = str_replace("e", "e҉", $nick3);
$nick3 = str_replace("r", "r҉", $nick3);
$nick3 = str_replace("t", "t҉", $nick3);
$nick3 = str_replace("y", "y҉", $nick3);
$nick3 = str_replace("u", "u҉", $nick3);
$nick3 = str_replace("i", "i҉", $nick3);
$nick3 = str_replace("o", "o҉", $nick3);
$nick3 = str_replace("p", "p҉", $nick3);
$nick3 = str_replace("a", "a҉", $nick3);
$nick3 = str_replace("s", "s҉", $nick3);
$nick3 = str_replace("d", "d҉", $nick3);
$nick3 = str_replace("f", "f҉", $nick3);
$nick3 = str_replace("g", "g҉", $nick3);
$nick3 = str_replace("h", "h҉", $nick3);
$nick3 = str_replace("j", "j҉", $nick3);
$nick3 = str_replace("k", "k҉", $nick3);
$nick3 = str_replace("l", "l҉", $nick3);
$nick3 = str_replace("z", "z҉", $nick3);
$nick3 = str_replace("x", "x҉", $nick3);
$nick3 = str_replace("c", "c҉", $nick3);
$nick3 = str_replace("v", "v҉", $nick3);
$nick3 = str_replace("b", "b҉", $nick3);
$nick3 = str_replace("n", "n҉", $nick3);
$nick3 = str_replace("m", "m҉", $nick3);

$nick3 = str_replace("Q", "Q҉", $nick3);
$nick3 = str_replace("W", "W҉", $nick3);
$nick3 = str_replace("E", "E҉", $nick3);
$nick3 = str_replace("R", "R҉", $nick3);
$nick3 = str_replace("T", "T҉", $nick3);
$nick3 = str_replace("Y", "Y҉", $nick3);
$nick3 = str_replace("U", "U҉", $nick3);
$nick3 = str_replace("I", "I҉", $nick3);
$nick3 = str_replace("O", "O҉", $nick3);
$nick3 = str_replace("P", "P҉", $nick3);
$nick3 = str_replace("A", "A҉", $nick3);
$nick3 = str_replace("S", "S҉", $nick3);
$nick3 = str_replace("D", "D҉", $nick3);
$nick3 = str_replace("F", "F҉", $nick3);
$nick3 = str_replace("G", "G҉", $nick3);
$nick3 = str_replace("H", "H҉", $nick3);
$nick3 = str_replace("J", "J҉", $nick3);
$nick3 = str_replace("K", "K҉", $nick3);
$nick3 = str_replace("L", "L҉", $nick3);
$nick3 = str_replace("Z", "Z҉", $nick3);
$nick3 = str_replace("X", "X҉", $nick3);
$nick3 = str_replace("C", "C҉", $nick3);
$nick3 = str_replace("V", "V҉", $nick3);
$nick3 = str_replace("B", "B҉", $nick3);
$nick3 = str_replace("N", "N҉", $nick3);
$nick3 = str_replace("M", "M҉", $nick3);

$nick4 = $tx;
$nick4 = str_replace("q", "🆀", $nick4);
$nick4 = str_replace("w", "🆆", $nick4);
$nick4 = str_replace("e", "🅴", $nick4);
$nick4 = str_replace("r", "🆁", $nick4);
$nick4 = str_replace("t", "🆃", $nick4);
$nick4 = str_replace("y", "🆈", $nick4);
$nick4 = str_replace("u", "🆄", $nick4);
$nick4 = str_replace("i", "🅸", $nick4);
$nick4 = str_replace("o", "🅾", $nick4);
$nick4 = str_replace("p", "🅿", $nick4);
$nick4 = str_replace("a", "🅰", $nick4);
$nick4 = str_replace("s", "🆂", $nick4);
$nick4 = str_replace("d", "🅳", $nick4);
$nick4 = str_replace("f", "🅵", $nick4);
$nick4 = str_replace("g", "🅶", $nick4);
$nick4 = str_replace("h", "🅷", $nick4);
$nick4 = str_replace("j", "🅹", $nick4);
$nick4 = str_replace("k", "🅺", $nick4);
$nick4 = str_replace("l", "🅻", $nick4);
$nick4 = str_replace("z", "🆉", $nick4);
$nick4 = str_replace("x", "🆇", $nick4);
$nick4 = str_replace("c", "🅲", $nick4);
$nick4 = str_replace("v", "🆅", $nick4);
$nick4 = str_replace("b", "🅱", $nick4);
$nick4 = str_replace("n", "🅽", $nick4);
$nick4 = str_replace("m", "🅼", $nick4);

$nick4 = str_replace("Q", "🆀", $nick4);
$nick4 = str_replace("W", "🆆", $nick4);
$nick4 = str_replace("E", "🅴", $nick4);
$nick4 = str_replace("R", "🆁", $nick4);
$nick4 = str_replace("T", "🆃", $nick4);
$nick4 = str_replace("Y", "🆈", $nick4);
$nick4 = str_replace("U", "🆄", $nick4);
$nick4 = str_replace("I", "🅸", $nick4);
$nick4 = str_replace("O", "🅾", $nick4);
$nick4 = str_replace("P", "🅿", $nick4);
$nick4 = str_replace("A", "🅰", $nick4);
$nick4 = str_replace("S", "🆂", $nick4);
$nick4 = str_replace("D", "🅳", $nick4);
$nick4 = str_replace("F", "🅵", $nick4);
$nick4 = str_replace("G", "🅶", $nick4);
$nick4 = str_replace("H", "🅷", $nick4);
$nick4 = str_replace("J", "🅹", $nick4);
$nick4 = str_replace("K", "🅺", $nick4);
$nick4 = str_replace("L", "🅻", $nick4);
$nick4 = str_replace("Z", "🆉", $nick4);
$nick4 = str_replace("X", "🆇", $nick4);
$nick4 = str_replace("C", "🅲", $nick4);
$nick4 = str_replace("V", "🆅", $nick4);
$nick4 = str_replace("B", "🅱", $nick4);
$nick4 = str_replace("N", "🅽", $nick4);
$nick4 = str_replace("M", "🅼", $nick4);
#-------------------------------------#
$nick5 = $tx;
$nick5 = str_replace("q", "ǫ", $nick5);
$nick5 = str_replace("w", "ᴡ", $nick5);
$nick5 = str_replace("e", "ᴇ", $nick5);
$nick5 = str_replace("r", "ʀ", $nick5);
$nick5 = str_replace("t", "ᴛ", $nick5);
$nick5 = str_replace("y", "ʏ", $nick5);
$nick5 = str_replace("u", "ᴜ", $nick5);
$nick5 = str_replace("i", "ɪ", $nick5);
$nick5 = str_replace("o", "ᴏ", $nick5);
$nick5 = str_replace("p", "ᴘ", $nick5);
$nick5 = str_replace("a", "ᴀ", $nick5);
$nick5 = str_replace("s", "s", $nick5);
$nick5 = str_replace("d", "ᴅ", $nick5);
$nick5 = str_replace("f", "ꜰ", $nick5);
$nick5 = str_replace("g", "ɢ", $nick5);
$nick5 = str_replace("h", "ʜ", $nick5);
$nick5 = str_replace("j", "ᴊ", $nick5);
$nick5 = str_replace("k", "ᴋ", $nick5);
$nick5 = str_replace("l", "ʟ", $nick5);
$nick5 = str_replace("z", "ᴢ", $nick5);
$nick5 = str_replace("x", "x", $nick5);
$nick5 = str_replace("c", "ᴄ", $nick5);
$nick5 = str_replace("v", "ᴠ", $nick5);
$nick5 = str_replace("b", "ʙ", $nick5);
$nick5 = str_replace("n", "ɴ", $nick5);
$nick5 = str_replace("m", "ᴍ", $nick5);

$nick5 = str_replace("Q", "ǫ", $nick5);
$nick5 = str_replace("W", "ᴡ", $nick5);
$nick5 = str_replace("E", "ᴇ", $nick5);
$nick5 = str_replace("R", "ʀ", $nick5);
$nick5 = str_replace("T", "ᴛ", $nick5);
$nick5 = str_replace("Y", "ʏ", $nick5);
$nick5 = str_replace("U", "ᴜ", $nick5);
$nick5 = str_replace("I", "ɪ", $nick5);
$nick5 = str_replace("O", "ᴏ", $nick5);
$nick5 = str_replace("P", "ᴘ", $nick5);
$nick5 = str_replace("A", "ᴀ", $nick5);
$nick5 = str_replace("S", "s", $nick5);
$nick5 = str_replace("D", "ᴅ", $nick5);
$nick5 = str_replace("F", "ꜰ", $nick5);
$nick5 = str_replace("G", "ɢ", $nick5);
$nick5 = str_replace("G", "ʜ", $nick5);
$nick5 = str_replace("J", "ᴊ", $nick5);
$nick5 = str_replace("K", "ᴋ", $nick5);
$nick5 = str_replace("L", "ʟ", $nick5);
$nick5 = str_replace("Z", "ᴢ", $nick5);
$nick5 = str_replace("X", "x", $nick5);
$nick5 = str_replace("C", "ᴄ", $nick5);
$nick5 = str_replace("V", "ᴠ", $nick5);
$nick5 = str_replace("B", "ʙ", $nick5);
$nick5 = str_replace("N", "ɴ", $nick5);
$nick5 = str_replace("M", "ᴍ", $nick5);
#-------------------------------------#
$nick7 = $tx;
$nick7 = str_replace("q", "b", $nick7);
$nick7 = str_replace("w", "ʍ", $nick7);
$nick7 = str_replace("e", "ǝ", $nick7);
$nick7 = str_replace("r", "ɹ", $nick7);
$nick7 = str_replace("t", "ʇ", $nick7);
$nick7 = str_replace("y", "ʎ", $nick7);
$nick7 = str_replace("u", "n", $nick7);
$nick7 = str_replace("i", "ı", $nick7);
$nick7 = str_replace("o", "o", $nick7);
$nick7 = str_replace("p", "d", $nick7);
$nick7 = str_replace("a", "ɐ", $nick7);
$nick7 = str_replace("s", "s", $nick7);
$nick7 = str_replace("d", "p", $nick7);
$nick7 = str_replace("f", "ɟ", $nick7);
$nick7 = str_replace("g", "ƃ", $nick7);
$nick7 = str_replace("h", "ɥ", $nick7);
$nick7 = str_replace("j", "ɾ", $nick7);
$nick7 = str_replace("k", "ʞ", $nick7);
$nick7 = str_replace("l", "ן", $nick7);
$nick7 = str_replace("z", "z", $nick7);
$nick7 = str_replace("x", "x", $nick7);
$nick7 = str_replace("c", "ɔ", $nick7);
$nick7 = str_replace("v", "𐌡", $nick7);
$nick7 = str_replace("b", "q", $nick7);
$nick7 = str_replace("n", "u", $nick7);
$nick7 = str_replace("m", "ɯ", $nick7);

$nick7 = str_replace("Q", "b", $nick7);
$nick7 = str_replace("W", "ʍ", $nick7);
$nick7 = str_replace("E", "ǝ", $nick7);
$nick7 = str_replace("R", "ɹ", $nick7);
$nick7 = str_replace("T", "ʇ", $nick7);
$nick7 = str_replace("Y", "ʎ", $nick7);
$nick7 = str_replace("U", "n", $nick7);
$nick7 = str_replace("I", "ı", $nick7);
$nick7 = str_replace("O", "o", $nick7);
$nick7 = str_replace("P", "d", $nick7);
$nick7 = str_replace("A", "ɐ", $nick7);
$nick7 = str_replace("S", "s", $nick7);
$nick7 = str_replace("D", "p", $nick7);
$nick7 = str_replace("F", "ɟ", $nick7);
$nick7 = str_replace("G", "ƃ", $nick7);
$nick7 = str_replace("H", "ɥ", $nick7);
$nick7 = str_replace("J", "ɾ", $nick7);
$nick7 = str_replace("K", "ʞ", $nick7);
$nick7 = str_replace("L", "ן", $nick7);
$nick7 = str_replace("Z", "z", $nick7);
$nick7 = str_replace("X", "x", $nick7);
$nick7 = str_replace("C", "ɔ", $nick7);
$nick7 = str_replace("V", "𐌡", $nick7);
$nick7 = str_replace("B", "q", $nick7);
$nick7 = str_replace("N", "u", $nick7);
$nick7 = str_replace("M", "ɯ", $nick7);
#-------------------------------------#
$nick8 = $tx;
$nick8 = str_replace("q", "b", $nick8);
$nick8 = str_replace("w", "ʍ", $nick8);
$nick8 = str_replace("e", "ǝ", $nick8);
$nick8 = str_replace("r", "ɹ", $nick8);
$nick8 = str_replace("t", "ʇ", $nick8);
$nick8 = str_replace("y", "ʎ", $nick8);
$nick8 = str_replace("u", "n", $nick8);
$nick8 = str_replace("i", "ı", $nick8);
$nick8 = str_replace("o", "o", $nick8);
$nick8 = str_replace("p", "d", $nick8);
$nick8 = str_replace("a", "ɐ", $nick8);
$nick8 = str_replace("s", "s", $nick8);
$nick8 = str_replace("d", "p", $nick8);
$nick8 = str_replace("f", "ɟ", $nick8);
$nick8 = str_replace("g", "ƃ", $nick8);
$nick8 = str_replace("h", "ɥ", $nick8);
$nick8 = str_replace("j", "ɾ", $nick8);
$nick8 = str_replace("k", "ʞ", $nick8);
$nick8 = str_replace("l", "ן", $nick8);
$nick8 = str_replace("z", "z", $nick8);
$nick8 = str_replace("x", "x", $nick8);
$nick8 = str_replace("c", "ɔ", $nick8);
$nick8 = str_replace("v", "𐌡", $nick8);
$nick8 = str_replace("b", "q", $nick8);
$nick8 = str_replace("n", "u", $nick8);
$nick8 = str_replace("m", "ɯ", $nick8);

$nick8 = str_replace("Q", "b", $nick8);
$nick8 = str_replace("W", "ʍ", $nick8);
$nick8 = str_replace("E", "ǝ", $nick8);
$nick8 = str_replace("R", "ɹ", $nick8);
$nick8 = str_replace("T", "ʇ", $nick8);
$nick8 = str_replace("Y", "ʎ", $nick8);
$nick8 = str_replace("U", "n", $nick8);
$nick8 = str_replace("I", "ı", $nick8);
$nick8 = str_replace("O", "o", $nick8);
$nick8 = str_replace("P", "d", $nick8);
$nick8 = str_replace("A", "ɐ", $nick8);
$nick8 = str_replace("S", "s", $nick8);
$nick8 = str_replace("D", "p", $nick8);
$nick8 = str_replace("F", "ɟ", $nick8);
$nick8 = str_replace("G", "ƃ", $nick8);
$nick8 = str_replace("H", "ɥ", $nick8);
$nick8 = str_replace("J", "ɾ", $nick8);
$nick8 = str_replace("K", "ʞ", $nick8);
$nick8 = str_replace("L", "ן", $nick8);
$nick8 = str_replace("Z", "z", $nick8);
$nick8 = str_replace("X", "x", $nick8);
$nick8 = str_replace("C", "ɔ", $nick8);
$nick8 = str_replace("V", "𐌡", $nick8);
$nick8 = str_replace("B", "q", $nick8);
$nick8 = str_replace("N", "u", $nick8);
$nick8 = str_replace("M", "ɯ", $nick8);
#-------------------------------------#
$nick9 = $tx;
$nick9 = str_replace("q", "🇶 ", $nick9);
$nick9 = str_replace("w", "🇼 ", $nick9);
$nick9 = str_replace("e", "🇪 ", $nick9);
$nick9 = str_replace("r", "🇷 ", $nick9);
$nick9 = str_replace("t", "🇹 ", $nick9);
$nick9 = str_replace("y", "🇾 ", $nick9);
$nick9 = str_replace("u", "🇺 ", $nick9);
$nick9 = str_replace("i", "🇮 ", $nick9);
$nick9 = str_replace("o", "🇴 ", $nick9);
$nick9 = str_replace("p", "🇵 ", $nick9);
$nick9 = str_replace("a", "🇦 ", $nick9);
$nick9 = str_replace("s", "🇸 ", $nick9);
$nick9 = str_replace("d", "🇩 ", $nick9);
$nick9 = str_replace("f", "🇫 ", $nick9);
$nick9 = str_replace("g", "🇬 ", $nick9);
$nick9 = str_replace("h", "🇭 ", $nick9);
$nick9 = str_replace("j", "🇯 ", $nick9);
$nick9 = str_replace("k", "🇰 ", $nick9);
$nick9 = str_replace("l", "🇱 ", $nick9);
$nick9 = str_replace("z", "🇿 ", $nick9);
$nick9 = str_replace("x", "🇽 ", $nick9);
$nick9 = str_replace("c", "🇨 ", $nick9);
$nick9 = str_replace("v", "🇻 ", $nick9);
$nick9 = str_replace("b", "🇧 ", $nick9);
$nick9 = str_replace("n", "🇳 ", $nick9);
$nick9 = str_replace("m", "🇲 ", $nick9);

$nick9 = str_replace("Q", "🇶 ", $nick9);
$nick9 = str_replace("W", "🇼 ", $nick9);
$nick9 = str_replace("E", "🇪 ", $nick9);
$nick9 = str_replace("R", "🇷 ", $nick9);
$nick9 = str_replace("T", "🇹 ", $nick9);
$nick9 = str_replace("Y", "🇾 ", $nick9);
$nick9 = str_replace("U", "🇺 ", $nick9);
$nick9 = str_replace("I", "🇮 ", $nick9);
$nick9 = str_replace("O", "🇴 ", $nick9);
$nick9 = str_replace("P", "🇵 ", $nick9);
$nick9 = str_replace("A", "🇦 ", $nick9);
$nick9 = str_replace("S", "🇸 ", $nick9);
$nick9 = str_replace("D", "🇩 ", $nick9);
$nick9 = str_replace("F", "🇫 ", $nick9);
$nick9 = str_replace("G", "🇬 ", $nick9);
$nick9 = str_replace("H", "🇭 ", $nick9);
$nick9 = str_replace("J", "🇯 ", $nick9);
$nick9 = str_replace("K", "🇰 ", $nick9);
$nick9 = str_replace("L", "🇱 ", $nick9);
$nick9 = str_replace("Z", "🇿 ", $nick9);
$nick9 = str_replace("X", "🇽 ", $nick9);
$nick9 = str_replace("C", "🇨 ", $nick9);
$nick9 = str_replace("V", "🇻 ", $nick9);
$nick9 = str_replace("B", "🇧 ", $nick9);
$nick9 = str_replace("N", "🇳 ", $nick9);
$nick9 = str_replace("M", "🇲 ", $nick9);
bot('sendmessage',[
'chat_id'=>$cid,
'text'=>"<b>Ismingizga nik tayor ✅</b>

<code>★彡  $nick1  彡★</code>

<code>꧁☬ $nick2 ☬꧂</code>

<code>❮꯭❶꯭꯭➣꯭  $nick7  ꯭✦꯭•꯭|꯭🖤 </code>

<code> ꯭😻🪐 $nick3 🌪🌿➢❭🦅</code>

<code>➤꯭🥀 $nick4 🍷🌪ꦿ🐊</code>

<code>• $nick5  ོོ</code>

<code>✺꯭➣꯭ꪾ🦅 $nick8 🌿✺➢ꪾ</code>

<code> ꯭🖤|•|꯭💫 $nick9  ꯭|•꯭|꯭🔥|•</code>

<i>😊Xoxlagan nikni ustiga bosib nusxalab olishingiz mumkin:</i> @$botname 💫",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"menyu"]],
]])
]);
unlink("step/$cid.txt");
}}

if($data == "videolar" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>💛 Video yasash bo'limiga xush kelibsiz!</b>

Quyidagilardan birini tanlang:",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"A 🦁",'callback_data'=>"a"],['text'=>"B 🌸",'callback_data'=>"b"],['text'=>"D ❤️",'callback_data'=>"d"],['text'=>"E 💫",'callback_data'=>"e"]],
[['text'=>"F 🦋",'callback_data'=>"f"],['text'=>"G 🪐",'callback_data'=>"g"],['text'=>"H ☘",'callback_data'=>"h"],['text'=>"I 💟",'callback_data'=>"i"]],
[['text'=>"J 🌼",'callback_data'=>"j"],['text'=>"K 🌪",'callback_data'=>"k"],['text'=>"L 🍒",'callback_data'=>"l"],['text'=>"M 🐣",'callback_data'=>"m"]],
[['text'=>"N 🧸",'callback_data'=>"n"],['text'=>"O 🥰",'callback_data'=>"o"],['text'=>"P 💜",'callback_data'=>"p"],['text'=>"Q 🐢",'callback_data'=>"q"]],
[['text'=>"R 🌟",'callback_data'=>"r"],['text'=>"S 🥥",'callback_data'=>"s"],['text'=>"T 🌊",'callback_data'=>"t"],['text'=>"U 😇",'callback_data'=>"u"]],
[['text'=>"V 🎉",'callback_data'=>"v"],['text'=>"X 🔗",'callback_data'=>"x"],['text'=>"Y 🤎",'callback_data'=>"y"],['text'=>"Z 🔐",'callback_data'=>"z"]],
[['text'=>"O' 🐳",'callback_data'=>"og"],['text'=>"G' 🍓",'callback_data'=>"go"],['text'=>"Sh ✨",'callback_data'=>"sh"],['text'=>"Ch 🦅",'callback_data'=>"ch"]],
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"menyu"]],
]])
]);
}

if($data=="a" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/346",
'caption'=>"<b>🌟 Tanlagan video yuklandi ✅

🎉 Sizga yoqan bolsa do’stlarga 
ham botimizni ulashing 💫

🤗 Botimiz : @$botname 💙</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"💌 Do'stlarga ulashish 🔗",'url'=>"https://t.me/share/url?url=https://t.me/$botname%0D%0A%20✨Shu%20Bbt%20Orqali%20ismingizga%20video%20yasab%20oling❤️"]],
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"videolar"]],
]])
]);
}

if($data=="b" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/347",
'caption'=>"<b>🌟 Tanlagan video yuklandi ✅

🎉 Sizga yoqan bolsa do’stlarga 
ham botimizni ulashing 💫

🤗 Botimiz : @$botname 💙</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"💌 Do'stlarga ulashish 🔗",'url'=>"https://t.me/share/url?url=https://t.me/$botname%0D%0A%20✨Shu%20Bbt%20Orqali%20ismingizga%20video%20yasab%20oling❤️"]],
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"videolar"]],
]])
]);
}

if($data=="d" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/348",
'caption'=>"<b>🌟 Tanlagan video yuklandi ✅

🎉 Sizga yoqan bolsa do’stlarga 
ham botimizni ulashing 💫

🤗 Botimiz : @$botname 💙</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"💌 Do'stlarga ulashish 🔗",'url'=>"https://t.me/share/url?url=https://t.me/$botname%0D%0A%20✨Shu%20Bbt%20Orqali%20ismingizga%20video%20yasab%20oling❤️"]],
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"videolar"]],
]])
]);
}

if($data=="e" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/349",
'caption'=>"<b>🌟 Tanlagan video yuklandi ✅

🎉 Sizga yoqan bolsa do’stlarga 
ham botimizni ulashing 💫

🤗 Botimiz : @$botname 💙</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"💌 Do'stlarga ulashish 🔗",'url'=>"https://t.me/share/url?url=https://t.me/$botname%0D%0A%20✨Shu%20Bbt%20Orqali%20ismingizga%20video%20yasab%20oling❤️"]],
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"videolar"]],
]])
]);
}

if($data=="f" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/350",
'caption'=>"<b>🌟 Tanlagan video yuklandi ✅

🎉 Sizga yoqan bolsa do’stlarga 
ham botimizni ulashing 💫

🤗 Botimiz : @$botname 💙</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"💌 Do'stlarga ulashish 🔗",'url'=>"https://t.me/share/url?url=https://t.me/$botname%0D%0A%20✨Shu%20Bbt%20Orqali%20ismingizga%20video%20yasab%20oling❤️"]],
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"videolar"]],
]])
]);
}

if($data=="g" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/351",
'caption'=>"<b>🌟 Tanlagan video yuklandi ✅

🎉 Sizga yoqan bolsa do’stlarga 
ham botimizni ulashing 💫

🤗 Botimiz : @$botname 💙</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"💌 Do'stlarga ulashish 🔗",'url'=>"https://t.me/share/url?url=https://t.me/$botname%0D%0A%20✨Shu%20Bbt%20Orqali%20ismingizga%20video%20yasab%20oling❤️"]],
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"videolar"]],
]])
]);
}

if($data=="h" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/352",
'caption'=>"<b>🌟 Tanlagan video yuklandi ✅

🎉 Sizga yoqan bolsa do’stlarga 
ham botimizni ulashing 💫

🤗 Botimiz : @$botname 💙</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"💌 Do'stlarga ulashish 🔗",'url'=>"https://t.me/share/url?url=https://t.me/$botname%0D%0A%20✨Shu%20Bbt%20Orqali%20ismingizga%20video%20yasab%20oling❤️"]],
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"videolar"]],
]])
]);
}

if($data=="i" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/353",
'caption'=>"<b>🌟 Tanlagan video yuklandi ✅

🎉 Sizga yoqan bolsa do’stlarga 
ham botimizni ulashing 💫

🤗 Botimiz : @$botname 💙</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"💌 Do'stlarga ulashish 🔗",'url'=>"https://t.me/share/url?url=https://t.me/$botname%0D%0A%20✨Shu%20Bbt%20Orqali%20ismingizga%20video%20yasab%20oling❤️"]],
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"videolar"]],
]])
]);
}

if($data=="j" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/354",
'caption'=>"<b>🌟 Tanlagan video yuklandi ✅

🎉 Sizga yoqan bolsa do’stlarga 
ham botimizni ulashing 💫

🤗 Botimiz : @$botname 💙</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"💌 Do'stlarga ulashish 🔗",'url'=>"https://t.me/share/url?url=https://t.me/$botname%0D%0A%20✨Shu%20Bbt%20Orqali%20ismingizga%20video%20yasab%20oling❤️"]],
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"videolar"]],
]])
]);
}

if($data=="k" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/355",
'caption'=>"<b>🌟 Tanlagan video yuklandi ✅

🎉 Sizga yoqan bolsa do’stlarga 
ham botimizni ulashing 💫

🤗 Botimiz : @$botname 💙</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"💌 Do'stlarga ulashish 🔗",'url'=>"https://t.me/share/url?url=https://t.me/$botname%0D%0A%20✨Shu%20Bbt%20Orqali%20ismingizga%20video%20yasab%20oling❤️"]],
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"videolar"]],
]])
]);
}

if($data=="l" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/356",
'caption'=>"<b>🌟 Tanlagan video yuklandi ✅

🎉 Sizga yoqan bolsa do’stlarga 
ham botimizni ulashing 💫

🤗 Botimiz : @$botname 💙</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"💌 Do'stlarga ulashish 🔗",'url'=>"https://t.me/share/url?url=https://t.me/$botname%0D%0A%20✨Shu%20Bbt%20Orqali%20ismingizga%20video%20yasab%20oling❤️"]],
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"videolar"]],
]])
]);
}

if($data=="m" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/357",
'caption'=>"<b>🌟 Tanlagan video yuklandi ✅

🎉 Sizga yoqan bolsa do’stlarga 
ham botimizni ulashing 💫

🤗 Botimiz : @$botname 💙</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"💌 Do'stlarga ulashish 🔗",'url'=>"https://t.me/share/url?url=https://t.me/$botname%0D%0A%20✨Shu%20Bbt%20Orqali%20ismingizga%20video%20yasab%20oling❤️"]],
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"videolar"]],
]])
]);
}

if($data=="n" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/358",
'caption'=>"<b>🌟 Tanlagan video yuklandi ✅

🎉 Sizga yoqan bolsa do’stlarga 
ham botimizni ulashing 💫

🤗 Botimiz : @$botname 💙</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"💌 Do'stlarga ulashish 🔗",'url'=>"https://t.me/share/url?url=https://t.me/$botname%0D%0A%20✨Shu%20Bbt%20Orqali%20ismingizga%20video%20yasab%20oling❤️"]],
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"videolar"]],
]])
]);
}

if($data=="o" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/359",
'caption'=>"<b>🌟 Tanlagan video yuklandi ✅

🎉 Sizga yoqan bolsa do’stlarga 
ham botimizni ulashing 💫

🤗 Botimiz : @$botname 💙</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"💌 Do'stlarga ulashish 🔗",'url'=>"https://t.me/share/url?url=https://t.me/$botname%0D%0A%20✨Shu%20Bbt%20Orqali%20ismingizga%20video%20yasab%20oling❤️"]],
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"videolar"]],
]])
]);
}

if($data=="p" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/360",
'caption'=>"<b>🌟 Tanlagan video yuklandi ✅

🎉 Sizga yoqan bolsa do’stlarga 
ham botimizni ulashing 💫

🤗 Botimiz : @$botname 💙</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"💌 Do'stlarga ulashish 🔗",'url'=>"https://t.me/share/url?url=https://t.me/$botname%0D%0A%20✨Shu%20Bbt%20Orqali%20ismingizga%20video%20yasab%20oling❤️"]],
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"videolar"]],
]])
]);
}

if($data=="q" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/361",
'caption'=>"<b>🌟 Tanlagan video yuklandi ✅

🎉 Sizga yoqan bolsa do’stlarga 
ham botimizni ulashing 💫

🤗 Botimiz : @$botname 💙</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"💌 Do'stlarga ulashish 🔗",'url'=>"https://t.me/share/url?url=https://t.me/$botname%0D%0A%20✨Shu%20Bbt%20Orqali%20ismingizga%20video%20yasab%20oling❤️"]],
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"videolar"]],
]])
]);
}

if($data=="r" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/362",
'caption'=>"<b>🌟 Tanlagan video yuklandi ✅

🎉 Sizga yoqan bolsa do’stlarga 
ham botimizni ulashing 💫

🤗 Botimiz : @$botname 💙</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"💌 Do'stlarga ulashish 🔗",'url'=>"https://t.me/share/url?url=https://t.me/$botname%0D%0A%20✨Shu%20Bbt%20Orqali%20ismingizga%20video%20yasab%20oling❤️"]],
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"videolar"]],
]])
]);
}

if($data=="s" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/363",
'caption'=>"<b>🌟 Tanlagan video yuklandi ✅

🎉 Sizga yoqan bolsa do’stlarga 
ham botimizni ulashing 💫

🤗 Botimiz : @$botname 💙</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"💌 Do'stlarga ulashish 🔗",'url'=>"https://t.me/share/url?url=https://t.me/$botname%0D%0A%20✨Shu%20Bbt%20Orqali%20ismingizga%20video%20yasab%20oling❤️"]],
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"videolar"]],
]])
]);
}

if($data=="t" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/364",
'caption'=>"<b>🌟 Tanlagan video yuklandi ✅

🎉 Sizga yoqan bolsa do’stlarga 
ham botimizni ulashing 💫

🤗 Botimiz : @$botname 💙</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"💌 Do'stlarga ulashish 🔗",'url'=>"https://t.me/share/url?url=https://t.me/$botname%0D%0A%20✨Shu%20Bbt%20Orqali%20ismingizga%20video%20yasab%20oling❤️"]],
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"videolar"]],
]])
]);
}

if($data=="u" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/365",
'caption'=>"<b>🌟 Tanlagan video yuklandi ✅

🎉 Sizga yoqan bolsa do’stlarga 
ham botimizni ulashing 💫

🤗 Botimiz : @$botname 💙</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"💌 Do'stlarga ulashish 🔗",'url'=>"https://t.me/share/url?url=https://t.me/$botname%0D%0A%20✨Shu%20Bbt%20Orqali%20ismingizga%20video%20yasab%20oling❤️"]],
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"videolar"]],
]])
]);
}

if($data=="v" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/366",
'caption'=>"<b>🌟 Tanlagan video yuklandi ✅

🎉 Sizga yoqan bolsa do’stlarga 
ham botimizni ulashing 💫

🤗 Botimiz : @$botname 💙</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"💌 Do'stlarga ulashish 🔗",'url'=>"https://t.me/share/url?url=https://t.me/$botname%0D%0A%20✨Shu%20Bbt%20Orqali%20ismingizga%20video%20yasab%20oling❤️"]],
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"videolar"]],
]])
]);
}

if($data=="x" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/367",
'caption'=>"<b>🌟 Tanlagan video yuklandi ✅

🎉 Sizga yoqan bolsa do’stlarga 
ham botimizni ulashing 💫

🤗 Botimiz : @$botname 💙</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"💌 Do'stlarga ulashish 🔗",'url'=>"https://t.me/share/url?url=https://t.me/$botname%0D%0A%20✨Shu%20Bbt%20Orqali%20ismingizga%20video%20yasab%20oling❤️"]],
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"videolar"]],
]])
]);
}

if($data=="y" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/368",
'caption'=>"<b>🌟 Tanlagan video yuklandi ✅

🎉 Sizga yoqan bolsa do’stlarga 
ham botimizni ulashing 💫

🤗 Botimiz : @$botname 💙</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"💌 Do'stlarga ulashish 🔗",'url'=>"https://t.me/share/url?url=https://t.me/$botname%0D%0A%20✨Shu%20Bbt%20Orqali%20ismingizga%20video%20yasab%20oling❤️"]],
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"videolar"]],
]])
]);
}

if($data=="z" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/369",
'caption'=>"<b>🌟 Tanlagan video yuklandi ✅

🎉 Sizga yoqan bolsa do’stlarga 
ham botimizni ulashing 💫

🤗 Botimiz : @$botname 💙</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"💌 Do'stlarga ulashish 🔗",'url'=>"https://t.me/share/url?url=https://t.me/$botname%0D%0A%20✨Shu%20Bbt%20Orqali%20ismingizga%20video%20yasab%20oling❤️"]],
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"videolar"]],
]])
]);
}

if($data=="sh" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/372",
'caption'=>"<b>🌟 Tanlagan video yuklandi ✅

🎉 Sizga yoqan bolsa do’stlarga 
ham botimizni ulashing 💫

🤗 Botimiz : @$botname 💙</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"💌 Do'stlarga ulashish 🔗",'url'=>"https://t.me/share/url?url=https://t.me/$botname%0D%0A%20✨Shu%20Bbt%20Orqali%20ismingizga%20video%20yasab%20oling❤️"]],
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"videolar"]],
]])
]);
}

if($data=="ch" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/373",
'caption'=>"<b>🌟 Tanlagan video yuklandi ✅

🎉 Sizga yoqan bolsa do’stlarga 
ham botimizni ulashing 💫

🤗 Botimiz : @$botname 💙</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"💌 Do'stlarga ulashish 🔗",'url'=>"https://t.me/share/url?url=https://t.me/$botname%0D%0A%20✨Shu%20Bbt%20Orqali%20ismingizga%20video%20yasab%20oling❤️"]],
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"videolar"]],
]])
]);
}

if($data=="og" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/370",
'caption'=>"<b>🌟 Tanlagan video yuklandi ✅

🎉 Sizga yoqan bolsa do’stlarga 
ham botimizni ulashing 💫

🤗 Botimiz : @$botname 💙</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"💌 Do'stlarga ulashish 🔗",'url'=>"https://t.me/share/url?url=https://t.me/$botname%0D%0A%20✨Shu%20Bbt%20Orqali%20ismingizga%20video%20yasab%20oling❤️"]],
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"videolar"]],
]])
]);
}

if($data=="go" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/371",
'caption'=>"<b>🌟 Tanlagan video yuklandi ✅

🎉 Sizga yoqan bolsa do’stlarga 
ham botimizni ulashing 💫

🤗 Botimiz : @$botname 💙</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"💌 Do'stlarga ulashish 🔗",'url'=>"https://t.me/share/url?url=https://t.me/$botname%0D%0A%20✨Shu%20Bbt%20Orqali%20ismingizga%20video%20yasab%20oling❤️"]],
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"videolar"]],
]])
]);
}

if($data=="valyuta"){
function kurs(){
$response = "";
$xml = file_get_contents("http://cbu.uz/uzc/arkhiv-kursov-valyut/xml/");
$m = new SimpleXMLElement($xml);
foreach ($m as $val) {
if($val->Ccy == 'RUB'){
$response .= "🇷🇺 1 Rossiya rubli = ".$val->Rate." so'm\n";
}
if($val->Ccy == 'USD'){
$response .= "🇺🇸 1 Amerika dollari = ".$val->Rate." so'm\n";
}
if($val->Ccy == 'EUR'){
$response .= "🇪🇺 1 EVRO = ".$val->Rate." so'm\n";
}}
return $response;
} function Parse($p1, $p2, $p3) {
$num1 = strpos($p1, $p2);
if($num1 === false) return 0;
$num2 = substr($p1, $num1);
return strip_tags(substr($num2, 0, strpos($num2, $p3)));
}
$marhamat = kurs();
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>💷 Valyuta kursi sahifasiga xush kelibsiz!</b>

$marhamat",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard' => [
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"menyu"]],
]])
]);
}

if($data == "animatsa" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>❤️ Animatsiyalar bo'limiga xush kelibsiz!</b>

Quyidagilardan birini tanlang:",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❤️",'callback_data'=>"animatsa1"],['text'=>"🚓",'callback_data'=>"animatsa2"],['text'=>"⏳",'callback_data'=>"animatsa3"]],
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"menyu"]],
]])
]);
}

if($data == "animatsa1" and joinchat($ccid) == "true"){
bot('editMessageText',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"
🤍🤍🤍🤍🤍🤍🤍🤍🤍",
'parse_mode'=>"html",
]);
sleep(1);
bot('editMessageText',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"
🤍🤍🤍🤍🤍🤍🤍🤍🤍
🤍🤍❤️❤️🤍❤️❤️🤍🤍",
'parse_mode'=>"html",
]);
sleep(1);
bot('editMessageText',[ 
'chat_id'=>$ccid, 
'message_id'=>$cmid, 
'text'=>" 
🤍🤍🤍🤍🤍🤍🤍🤍🤍 
🤍🤍❤️❤️🤍❤️❤️🤍🤍 
🤍❤️❤️❤️❤️❤️❤️❤️🤍 ", 
'parse_mode'=>"html", 
]); 
sleep(1);
bot('editMessageText',[ 
'chat_id'=>$ccid, 
'message_id'=>$cmid, 
'text'=>" 
🤍🤍🤍🤍🤍🤍🤍🤍🤍 
🤍🤍❤️❤️🤍❤️❤️🤍🤍 
🤍❤️❤️❤️❤️❤️❤️❤️🤍 
🤍❤️❤️❤️❤️❤️❤️❤️🤍 ", 
'parse_mode'=>"html", 
]); 
sleep(1);
bot('editMessageText',[ 
'chat_id'=>$ccid, 
'message_id'=>$cmid, 
'text'=>" 
🤍🤍🤍🤍🤍🤍🤍🤍🤍 
🤍🤍❤️❤️🤍❤️❤️🤍🤍 
🤍❤️❤️❤️❤️❤️❤️❤️🤍 
🤍❤️❤️❤️❤️❤️❤️❤️🤍 
🤍❤️❤️❤️❤️❤️❤️❤️🤍 ", 
'parse_mode'=>"html", 
]); 
sleep(1);
bot('editMessageText',[ 
'chat_id'=>$ccid, 
'message_id'=>$cmid, 
'text'=>" 
🤍🤍🤍🤍🤍🤍🤍🤍🤍 
🤍🤍❤️❤️🤍❤️❤️🤍🤍 
🤍❤️❤️❤️❤️❤️❤️❤️🤍 
🤍❤️❤️❤️❤️❤️❤️❤️🤍 
🤍❤️❤️❤️❤️❤️❤️❤️🤍 
🤍🤍❤️❤️❤️❤️❤️🤍🤍 ", 
'parse_mode'=>"html", 
]); 
sleep(1);
bot('editMessageText',[ 
'chat_id'=>$ccid, 
'message_id'=>$cmid, 
'text'=>" 
🤍🤍🤍🤍🤍🤍🤍🤍🤍 
🤍🤍❤️❤️🤍❤️❤️🤍🤍 
🤍❤️❤️❤️❤️❤️❤️❤️🤍 
🤍❤️❤️❤️❤️❤️❤️❤️🤍 
🤍❤️❤️❤️❤️❤️❤️❤️🤍 
🤍🤍❤️❤️❤️❤️❤️🤍🤍 
🤍🤍🤍❤️❤️❤️🤍🤍🤍 ", 
'parse_mode'=>"html", 
]); 
sleep(1);
bot('editMessageText',[ 
'chat_id'=>$ccid, 
'message_id'=>$cmid, 
'text'=>" 
🤍🤍🤍🤍🤍🤍🤍🤍🤍 
🤍🤍❤️❤️🤍❤️❤️🤍🤍 
🤍❤️❤️❤️❤️❤️❤️❤️🤍 
🤍❤️❤️❤️❤️❤️❤️❤️🤍 
🤍❤️❤️❤️❤️❤️❤️❤️🤍 
🤍🤍❤️❤️❤️❤️❤️🤍🤍 
🤍🤍🤍❤️❤️❤️🤍🤍🤍 
🤍🤍🤍🤍❤️🤍🤍🤍🤍 ", 
'parse_mode'=>"html", 
]); 
sleep(1);
bot('editMessageText',[ 
'chat_id'=>$ccid, 
'message_id'=>$cmid, 
'text'=>" 
🤍🤍🤍🤍🤍🤍🤍🤍🤍 
🤍🤍❤️❤️🤍❤️❤️🤍🤍 
🤍❤️❤️❤️❤️❤️❤️❤️🤍 
🤍❤️❤️❤️❤️❤️❤️❤️🤍 
🤍❤️❤️❤️❤️❤️❤️❤️🤍 
🤍🤍❤️❤️❤️❤️❤️🤍🤍 
🤍🤍🤍❤️❤️❤️🤍🤍🤍 
🤍🤍🤍🤍❤️🤍🤍🤍🤍 
🤍🤍🤍🤍🤍🤍🤍🤍🤍", 
'parse_mode'=>"html", 
]); 
sleep(1);
bot('editMessageText',[ 
'chat_id'=>$ccid, 
'message_id'=>$cmid, 
'text'=>" 
🤍🤍🤍🤍🤍🤍🤍🤍🤍 
🤍🤍💖💖🤍💖💖🤍🤍 
🤍💖💖💖💖💖💖💖🤍 
🤍💖💖💖💖💖💖💖🤍 
🤍💖💖💖💖💖💖💖🤍 
🤍🤍💖💖💖💖💖️🤍🤍 
🤍🤍🤍💖💖💖️🤍🤍🤍 
🤍🤍🤍🤍💖🤍🤍🤍🤍 
🤍🤍🤍🤍🤍🤍🤍🤍🤍", 
'parse_mode'=>"html", 
]); 
sleep(2);
bot('editMessageText',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"<b>❤️ Animatsiyalar bo'limiga xush kelibsiz!</b>

Quyidagilardan birini tanlang:",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❤️",'callback_data'=>"animatsa1"],['text'=>"🚓",'callback_data'=>"animatsa2"],['text'=>"⏳",'callback_data'=>"animatsa3"]],
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"menyu"]],
]])
]);
}

if($data == "animatsa2" and joinchat($ccid) == "true"){
bot('editMessageText',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"
🔵🔵🔵🔵⬜️⬜️⬜️🔴🔴🔴🔴
🔵🔵🔵🔵⬜️⬜️⬜️🔴🔴🔴🔴
🔵🔵🔵🔵⬜️⬜️⬜️🔴🔴🔴🔴",
'parse_mode'=>"html",
]);
sleep(1);
bot('editMessageText',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"
🔴🔴🔴🔴⬜️⬜️⬜️🔵🔵🔵🔵
🔴🔴🔴🔴⬜️⬜️⬜️🔵🔵🔵🔵
🔴🔴🔴🔴⬜️⬜️⬜️🔵🔵🔵🔵",
'parse_mode'=>"html",
]);
sleep(1);
bot('editMessageText',[ 
'chat_id'=>$ccid, 
'message_id'=>$cmid, 
'text'=>" 
🔵🔵🔵🔵⬜️⬜️⬜️🔴🔴🔴🔴
🔵🔵🔵🔵⬜️⬜️⬜️🔴🔴🔴🔴
🔵🔵🔵🔵⬜️⬜️⬜️🔴🔴🔴🔴", 
'parse_mode'=>"html", 
]); 
sleep(1);
bot('editMessageText',[ 
'chat_id'=>$ccid, 
'message_id'=>$cmid, 
'text'=>" 
🔴🔴🔴🔴⬜️⬜️⬜️🔵🔵🔵🔵
🔴🔴🔴🔴⬜️⬜️⬜️🔵🔵🔵🔵
🔴🔴🔴🔴⬜️⬜️⬜️🔵🔵🔵🔵", 
'parse_mode'=>"html", 
]); 
sleep(1);
bot('editMessageText',[ 
'chat_id'=>$ccid, 
'message_id'=>$cmid, 
'text'=>" 
🔵🔵🔵🔵⬜️⬜️⬜️🔴🔴🔴🔴
🔵🔵🔵🔵⬜️⬜️⬜️🔴🔴🔴🔴
🔵🔵🔵🔵⬜️⬜️⬜️🔴🔴🔴🔴", 
'parse_mode'=>"html", 
]); 
sleep(1);
bot('editMessageText',[ 
'chat_id'=>$ccid, 
'message_id'=>$cmid, 
'text'=>" 
🔴🔴🔴🔴⬜️⬜️⬜️🔵🔵🔵🔵
🔴🔴🔴🔴⬜️⬜️⬜️🔵🔵🔵🔵
🔴🔴🔴🔴⬜️⬜️⬜️🔵🔵🔵🔵", 
'parse_mode'=>"html", 
]); 
sleep(1);
bot('editMessageText',[ 
'chat_id'=>$ccid, 
'message_id'=>$cmid, 
'text'=>" 
🔵🔵🔵🔵⬜️⬜️⬜️🔴🔴🔴🔴
🔵🔵🔵🔵⬜️⬜️⬜️🔴🔴🔴🔴
🔵🔵🔵🔵⬜️⬜️⬜️🔴🔴🔴🔴", 
'parse_mode'=>"html", 
]); 
sleep(1);
bot('editMessageText',[ 
'chat_id'=>$ccid, 
'message_id'=>$cmid, 
'text'=>"🚓", 
'parse_mode'=>"html", 
]); 
sleep(2);
bot('editMessageText',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"<b>❤️ Animatsiyalar bo'limiga xush kelibsiz!</b>

Quyidagilardan birini tanlang:",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❤️",'callback_data'=>"animatsa1"],['text'=>"🚓",'callback_data'=>"animatsa2"],['text'=>"⏳",'callback_data'=>"animatsa3"]],
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"menyu"]],
]])
]);
}

if($data == "animatsa3" and joinchat($ccid) == "true"){
bot('editMessageText',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"⏳ Vaqt o'tmoqda...",
'parse_mode'=>"html",
]);
sleep(1);
bot('editMessageText',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"⌛️ Vaqt o'tmoqda..",
'parse_mode'=>"html",
]);
sleep(1);
bot('editMessageText',[ 
'chat_id'=>$ccid, 
'message_id'=>$cmid, 
'text'=>"⏳ Vaqt o'tmoqda...", 
'parse_mode'=>"html", 
]); 
sleep(1);
bot('editMessageText',[ 
'chat_id'=>$ccid, 
'message_id'=>$cmid, 
'text'=>"⌛️ Vaqt o'tmoqda..", 
'parse_mode'=>"html", 
]); 
sleep(1);
bot('editMessageText',[ 
'chat_id'=>$ccid, 
'message_id'=>$cmid, 
'text'=>"⏳ Vaqt o'tmoqda...", 
'parse_mode'=>"html", 
]); 
sleep(1);
bot('editMessageText',[ 
'chat_id'=>$ccid, 
'message_id'=>$cmid, 
'text'=>"⌛️ Vaqt o'tmoqda..", 
'parse_mode'=>"html", 
]); 
sleep(1);
bot('editMessageText',[ 
'chat_id'=>$ccid, 
'message_id'=>$cmid, 
'text'=>"⏳ Vaqt o'tmoqda...", 
'parse_mode'=>"html", 
]); 
sleep(1);
bot('editMessageText',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"<b>❤️ Animatsiyalar bo'limiga xush kelibsiz!</b>

Quyidagilardan birini tanlang:",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❤️",'callback_data'=>"animatsa1"],['text'=>"🚓",'callback_data'=>"animatsa2"],['text'=>"⏳",'callback_data'=>"animatsa3"]],
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"menyu"]],
]])
]);
}

if($data == "fonlar" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>🌉 Yangi fonlar bo'limiga xush kelibsiz!</b>

O'rnatmoqchi bo'lgan fonni tanlang:",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🏖 FON",'url'=>"https://t.me/bg/sp-xMi7A-VEBAAAABRn6rGsUKFs"],['text'=>"🏠 FON",'url'=>"https://t.me/bg/Br6nNA9WAVIBAAAAe6AHvL7eOMM"],['text'=>"🏝 FON",'url'=>"https://t.me/bg/7wznfgBk-VEBAAAAncxYg0vokZY"]],
[['text'=>"🏭 FON",'url'=>"https://t.me/bg/7wznfgBk-VEBAAAAncxYg0vokZY"],['text'=>"🏔 FON",'url'=>"https://t.me/bg/CiwwsoTP-VEBAAAAmDYEizr71BQ"],['text'=>"🏤 FON",'url'=>"https://t.me/bg/MiE64ER4AFIBAAAAHQZRZyDCfu0"]],
[['text'=>"🗽 FON",'url'=>"https://t.me/bg/FJIYygt_iVIBAAAA8tzV8Ju0QvM"],['text'=>"⛈ FON",'url'=>"https://t.me/bg/EhCMFgys-FEBAAAA04qJyrs1G6M"],['text'=>"🛖 FON",'url'=>"https://t.me/bg/MzLRSHubAVIBAAAAqKgYQTObnhw"]],
[['text'=>"🏩 FON",'url'=>"https://t.me/bg/CiwwsoTP-VEBAAAAmDYEizr71BQ"],['text'=>"⛺️ FON",'url'=>"https://t.me/bg/7wznfgBk-VEBAAAAncxYg0vokZY"],['text'=>"⛪️ FON",'url'=>"https://t.me/bg/Qe9IiLLfiVIBAAAAn_BDUKSYaCs"]],
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"menyu"]],
]])
]);
}

if($data == "kulguli" and joinchat($ccid)=="true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>🔉 Kulguli ovoz bo'limiga xush kelibsiz!

1. Assalomu alekum – 00:03
2. Qalesz – 00:02
3. Rahmat rahmat – 00:04 
4. Akang kuchaydi – 00:12 
5. Toba qildim – 00:03 
6. Shuyam ferferomi diymanda – 00:13
7. Kecha ustimdan kulganlar – 00:14
8. Qiz bermaganlar – 00:07
9. Auf – 00:06
10. Rostan seryozni – 00:07</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"1",'callback_data'=>"kulgili1"],['text'=>"2",'callback_data'=>"kulgili2"],['text'=>"3",'callback_data'=>"kulgili3"],['text'=>"4",'callback_data'=>"kulgili4"],['text'=>"5",'callback_data'=>"kulgili5"]],
[['text'=>"6",'callback_data'=>"kulgili6"],['text'=>"7",'callback_data'=>"kulgili7"],['text'=>"8",'callback_data'=>"kulgili8"],['text'=>"9",'callback_data'=>"kulgili9"],['text'=>"10",'callback_data'=>"kulgili10"]],
[['text'=>"⏮",'callback_data'=>"kulgiliovoz"],['text'=>"🏠",'callback_data'=>"menyu"],['text'=>"️⏭",'callback_data'=>"kulgiliovoz2"]],

]])
]);
}

if($data == "kulgili1"){
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/120",
'caption'=>"🔉 Kulguli ovoz

🎙 Assalomu alekum",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌",'callback_data'=>"ochirish"]],
]])
]);
}

if($data == "kulgili2"){
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/121",
'caption'=>"🔉 Kulguli ovoz

🎙 Qalesz ",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌",'callback_data'=>"ochirish"]],
]])
]);
}

if($data == "kulgili3"){
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/122",
'caption'=>"🔉 Kulguli ovoz

🎙 Rahmat rahmat ",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌",'callback_data'=>"ochirish"]],
]])
]);
}

if($data == "kulgili4"){
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/123",
'caption'=>"🔉 Kulguli ovoz

🎙 Akang kuchaydi",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌",'callback_data'=>"ochirish"]],
]])
]);
}

if($data == "kulgili5"){
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/124",
'caption'=>"🔉 Kulguli ovoz

🎙 Toba qildim",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌",'callback_data'=>"ochirish"]],
]])
]);
}

if($data == "kulgili6"){
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/125",
'caption'=>"🔉 Kulguli ovoz

🎙 Shuyam ferferomi diymanda",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌",'callback_data'=>"ochirish"]],
]])
]);
}

if($data == "kulgili7"){
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/126",
'caption'=>"🔉 Kulguli ovoz

🎙 Kecha ustimdan kulganlar ",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌",'callback_data'=>"ochirish"]],
]])
]);
}

if($data == "kulgili8"){
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/127",
'caption'=>"🔉 Kulguli ovoz

🎙 Qiz bermaganlar",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌",'callback_data'=>"ochirish"]],
]])
]);
}

if($data == "kulgili9"){
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/128",
'caption'=>"🔉 Kulguli ovoz

🎙 Auf ",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌",'callback_data'=>"ochirish"]],
]])
]);
}

if($data == "kulgili10"){
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/129",
'caption'=>"🔉 Kulguli ovoz

🎙 Rostan seryozni ",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌",'callback_data'=>"ochirish"]],
]])
]);
}

if($data == "kulgiliovoz2"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendmessage',[
'chat_id'=>$ccid,
'text'=>"<b>🔉 Kulguli ovoz [2-Bo'lim]

1. Nma gaap – 00:02
2. Meni aytyapti – 00:02
3. Grupaga yozmaydiganlar – 00:12
4. Bugunga yetar – 00:04 
5. Boldi bas qil uxla – 00:09
6. prikolni da – 00:02
7. Bugun seni kuning – 00:29
8. Bir kecha mehmoning bo'lay – 00:40
9. Men chichib kelay – 00:04
10. Mazami silaga mazami – 00:06</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"1",'callback_data'=>"kulgili11"],['text'=>"2",'callback_data'=>"kulgili12"],['text'=>"3",'callback_data'=>"kulgili13"],['text'=>"4",'callback_data'=>"kulgili14"],['text'=>"5",'callback_data'=>"kulgili15"]],
[['text'=>"6",'callback_data'=>"kulgili16"],['text'=>"7",'callback_data'=>"kulgili17"],['text'=>"8",'callback_data'=>"kulgili18"],['text'=>"9",'callback_data'=>"kulgili19"],['text'=>"10",'callback_data'=>"kulgili20"]],
[['text'=>"⏮",'callback_data'=>"kulguli"],['text'=>"🏠",'callback_data'=>"menyu"],['text'=>"️⏭",'callback_data'=>"kulgiliovoz3"]],

]])
]);
}

if($data == "kulgili11"){
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/130",
'caption'=>"🔉 Kulguli ovoz

🎙 Nma gaap ",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌",'callback_data'=>"ochirish"]],
]])
]);
}

if($data == "kulgili12"){
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/131",
'caption'=>"🔉 Kulguli ovoz

🎙 Meni aytyapti ",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌",'callback_data'=>"ochirish"]],
]])
]);
}

if($data == "kulgili13"){
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/132",
'caption'=>"🔉 Kulguli ovoz

🎙 Gruppaga yozmaydiganlar ",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌",'callback_data'=>"ochirish"]],
]])
]);
}

if($data == "kulgili14"){
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/133",
'caption'=>"🔉 Kulguli ovoz

🎙 Bugunga yetar ",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌",'callback_data'=>"ochirish"]],
]])
]);
}

if($data == "kulgili15"){
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/134",
'caption'=>"🔉 Kulguli ovoz

🎙 Boldi bas qil uxla",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌",'callback_data'=>"ochirish"]],
]])
]);
}

if($data == "kulgili16"){
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/135",
'caption'=>"🔉 Kulguli ovoz

🎙 Prikolni da",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌",'callback_data'=>"ochirish"]],
]])
]);
}

if($data == "kulgili17"){
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/136",
'caption'=>"🔉 Kulguli ovoz

🎙 Bugun seni kuning ",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌",'callback_data'=>"ochirish"]],
]])
]);
}

if($data == "kulgili18"){
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/137",
'caption'=>"🔉 Kulguli ovoz

🎙 Bir kecha mehmoning bo'lay ",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌",'callback_data'=>"ochirish"]],
]])
]);
}

if($data == "kulgili19"){
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/138",
'caption'=>"🔉 Kulguli ovoz

🎙 Men chichib kelay",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌",'callback_data'=>"ochirish"]],
]])
]);
}

if($data == "kulgili20"){
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/139",
'caption'=>"🔉 Kulguli ovoz

🎙 Mazami silaga mazami",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌",'callback_data'=>"ochirish"]],
]])
]);
}

if($data == "kulgiliovoz3"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendmessage',[
'chat_id'=>$ccid,
'text'=>"<b>🔉 Kulguli ovoz [3-Bo'lim]

1. E chichqoq – 00:03
2. San kimsan – 00:13
3. Yo'qol – 00:02
4. Shu gapizga manavuni – 00:12 
5. Akang kuchaydi uje – 00:06
6. Uxlaaa – 00:02
7. Go'l – 00:07
8. Tugadi – 00:01
9. Indan keyinchi – 00:01
10. Oh no oh no – 00:07</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"1",'callback_data'=>"kulgili21"],['text'=>"2",'callback_data'=>"kulgili22"],['text'=>"3",'callback_data'=>"kulgili23"],['text'=>"4",'callback_data'=>"kulgili24"],['text'=>"5",'callback_data'=>"kulgili25"]],
[['text'=>"6",'callback_data'=>"kulgili26"],['text'=>"7",'callback_data'=>"kulgili27"],['text'=>"8",'callback_data'=>"kulgili28"],['text'=>"9",'callback_data'=>"kulgili29"],['text'=>"10",'callback_data'=>"kulgili30"]],
[['text'=>"⏮",'callback_data'=>"kulgiliovoz2"],['text'=>"🏠",'callback_data'=>"menyu"],['text'=>"️⏭",'callback_data'=>"kulgiliovoz4"]],
]])
]);
}

if($data == "kulgili21"){
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/140",
'caption'=>"🔉 Kulguli ovoz

🎙 E chichqoq",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌",'callback_data'=>"ochirish"]],
]])
]);
}

if($data == "kulgili22"){
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/141",
'caption'=>"🔉 Kulguli ovoz

🎙 San kimsan",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌",'callback_data'=>"ochirish"]],
]])
]);
}

if($data == "kulgili23"){
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/142",
'caption'=>"🔉 Kulguli ovoz

🎙 Yo'qol ",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌",'callback_data'=>"ochirish"]],
]])
]);
}

if($data == "kulgili24"){
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/143",
'caption'=>"🔉 Kulguli ovoz

🎙 Shu gapizga manavuni",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌",'callback_data'=>"ochirish"]],
]])
]);
}

if($data == "kulgili25"){
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/144",
'caption'=>"🔉 Kulguli ovoz

🎙 Akang kuchaydi uje",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌",'callback_data'=>"ochirish"]],
]])
]);
}

if($data == "kulgili26"){
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/145",
'caption'=>"🔉 Kulguli ovoz

🎙 Uxlaaa",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌",'callback_data'=>"ochirish"]],
]])
]);
}

if($data == "kulgili27"){
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/146",
'caption'=>"🔉 Kulguli ovoz

🎙 Go'l",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌",'callback_data'=>"ochirish"]],
]])
]);
}

if($data == "kulgili28"){
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/147",
'caption'=>"🔉 Kulguli ovoz

🎙 Tugadi",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌",'callback_data'=>"ochirish"]],
]])
]);
}

if($data == "kulgili29"){
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/148",
'caption'=>"🔉 Kulguli ovoz

🎙 Indan keyinchi",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌",'callback_data'=>"ochirish"]],
]])
]);
}

if($data == "kulgili30"){
bot('senddocument',[
'chat_id'=>$ccid,
'document'=>"https://t.me/botim1chi/149",
'caption'=>"🔉 Kulguli ovoz

🎙 Oh no oh no",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌",'callback_data'=>"ochirish"]],
]])
]);
}

if($data == "ochirish"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
}

if($data == "botbahola" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b><b>🌟 Botni baholash bo'limiga xush kelibsiz!</b>

@$botname'ni baxolang:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"⭐️",'callback_data'=>"biryulduz"]],
[['text'=>"⭐️⭐️",'callback_data'=>"ikkiyulduz"]],
[['text'=>"⭐️⭐️⭐️",'callback_data'=>"uchyulduz"]],
[['text'=>"⭐️⭐️⭐️⭐️",'callback_data'=>"tortyulduz"]],
[['text'=>"⭐️⭐️⭐️⭐️⭐️",'callback_data'=>"beshyulduz"]],
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"menyu"]],
]])
]);
}

if($data == "biryulduz" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>Botimizni baholashdi ️«⭐️»</b>",
'parse_mode'=>"html",
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>️« ⭐️ » uchun rahmat!</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"menyu"]],
]])
]);
}

if($data == "ikkiyulduz" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>Botimizni baholashdi ️«⭐️⭐️»</b>",
'parse_mode'=>"html",
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>️« ⭐⭐️️ » uchun rahmat️!</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"menyu"]],
]])
]);
}

if($data == "uchyulduz" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>Botimizni baholashdi ️«⭐️⭐️⭐️»</b>",
'parse_mode'=>"html",
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>️« ⭐⭐️⭐️️ » uchun rahmat️!</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"menyu"]],
]])
]);
}

if($data == "tortyulduz" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>Botimizni baholashdi ️«⭐️⭐️⭐️⭐️»</b>",
'parse_mode'=>"html",
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>️« ⭐⭐️⭐⭐️️️ » uchun rahmat️!</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"menyu"]],
]])
]);
}

if($data == "beshyulduz" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>Botimizni baholashdi ️«⭐️⭐️⭐️⭐️⭐️»</b>",
'parse_mode'=>"html",
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>️« ⭐⭐⭐️⭐️️⭐️️ » uchun rahmat️!</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"menyu"]],
]])
]);
}

if($data == "foydali" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>🪐 Foydali bo'lim sahifasiga xush kelibsiz!</b>

Quyidagilardan birini tanlang:",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🎄 Yangi yil vaqti",'callback_data'=>"yangi_yil"]],
[['text'=>"🥰 Go'zallik testi",'callback_data'=>"gozallik"],['text'=>"🌕 Tug'ilgan Oy",'callback_data'=>"tugilgan_oy"]],
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"menyu"]],
]])
]);
}

if($data=="yangi_yil" and joinchat($ccid) == "true"){
$kun1 = date('z',strtotime('2 hour')); 
$c2 = 364-$kun1;
$d = date('L',strtotime('2 hour'));
$b = $c2+$d;
$f = $b+81;
$e = $b+240;
$kun2 = date('H',strtotime('2 hour')); 
$b2 = 23-$kun2;
$kun3 = date('i',strtotime('2 hour')); 
$b3 = 59-$kun3;
$kun4 = date('s',strtotime('2 hour')); 
$b4 = 60-$kun4;
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>☃️ Yangi yilga bayramiga:

🎄 $b kun - $b2 soat - $b3 minut qoldi

🎅🏽 Hurmatli foydalanuvchi kirib kelayotgan yangi yil bilan!</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"foydali"]],
]])
]);
}

if($data=="gozallik" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>📝 Ismingizni yuboring:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"foydali"]],
]])
]);
file_put_contents("step/$ccid.txt","gozallik");
}
if($userstep=="gozallik"){
if($data=="menyu"){
unlink("step/$cid.txt");
}else{
$son = rand(30,99);
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>🔥 Go'zalik darajasi: $son%

❤️ Botga do'stlaringizni chaqirishni unutmang</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"foydali"]],
]])
]);
unlink("step/$cid.txt");
}}

if($data == "tugilgan_oy" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>Tugʻilgan oyingizni tanlang.</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"Yanvar",'callback_data'=>"oy1"],['text'=>"Fevral",'callback_data'=>"oy2"],['text'=>"Mart",'callback_data'=>"oy3"]],
[['text'=>"Aprel",'callback_data'=>"oy4"],['text'=>"May",'callback_data'=>"oy5"],['text'=>"Iyun",'callback_data'=>"oy6"]],
[['text'=>"Iyul",'callback_data'=>"oy7"],['text'=>"Avgust",'callback_data'=>"oy8"],['text'=>"Sentabr",'callback_data'=>"oy9"]],
[['text'=>"Oktabr",'callback_data'=>"oy10"],['text'=>"Noyabr",'callback_data'=>"oy11"],['text'=>"Dekabr",'callback_data'=>"oy12"]],
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"foydali"]],
]])
]);
}

if($data == "oy1" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>Yanvar.Shu oyda tugʻilgan boʻlsangiz, demak u muloyim va juda taʼsirchan. Doʻst-birodalardan yordamini ayashmaydi. Koʻngilsizliklardan toʻgʻri xulosa chiqarishga harakat qilishsa, omad qushi ularni tark etmaydi. Biroz sabrsizliklari sabab munosabatlarda tushunmovchilik kuzatilishi mumkin.</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"foydali"]],
]])
]);
}

if($data == "oy2" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>Fevral.Oʻziga ishongan, uyim-joyim deydigan, zakovatli erkaklar aynan shu oyda tugʻilarkan. Ayriliqdan qoʻrqishadi. Doim oila davrasiga shoshishadi. Ular uchun eng muhimi, oilaviy baxt. Bitta kamchiliklari kurashuvchanmas. Maqsadlari yoʻlida kichik muammo sabab ham hammasiga qoʻl siltab ketishadi.</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"foydali"]],
]])
]);
}

if($data == "oy3" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>Mart.Bahorning ilk oyida tugʻilgan erkaklar sogʻlom fikrlaydigan boʻlisharkan. Shu bilan birga, juda tejamkor ham. Pullarini tiyin-tiyinlab yiqqanlari uchun ham katta rejalarni bemalol amalga oshirishadi. Salbiy tomonlari – muammoli vaziyat tugʻilganda quyon boʻlishga usta.</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"foydali"]],
]])
]);
}

if($data == "oy4" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>Aprel.Katta boʻlsa-da, bolaligini qoʻymagan erkaklar tadbirkor va gapga toʻn kiydiradiganlardan. Aynan shu xususiyatlari sabab ular atrofdagilarni oʻz soʻziga ishontira olishadi va pul borasida omadlari chopadi. Maʼsuliyatli boʻlishsa, hayotda koʻp narsaga erisha olishardi.</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"foydali"]],
]])
]);
}

if($data == "oy5" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>May.Vahimakashligini hisobga olmasak, aqlli va topqirligi taxsinga loyiq. Xotirjamlik ular uchun juda muhim. Shuning uchun shovqin-suronga yoqlar. Hayotlari bir maromda kechishini istashadi. Oʻzgarishlardan choʻchishadi.</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"foydali"]],
]])
]);
}

if($data == "oy6" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>Iyun.Mazkur oyda tavallud topgan erkaklar barchaga birdek yaxshilik istashadi, qoʻldan kelgancha atrofdagilarga yordam qilishadi. Bu oyda tugʻilganlar bilan taqdiringizni bogʻlasangiz, hayotingiz farovon kechadi. Chunki ular har qanday vaziyatda ham oltin ortalikni topa olishadi. Salbiy jihatlari, salomataliklariga befarqligi.</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"foydali"]],
]])
]);
}

if($data == "oy7" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>Iyul.Favqulodda iqtidor egalari ayni shu oyda dunyoga kelishar ekan. Biroz xayolparatsliklari ham shundan. Ular mashhurlikka va boylikka intilishadi. Agar maqsadlari sari tinmay harakat qilishsa, erishishadi ham. Faqat uni doim olgʻa undab turishingiz kerak.</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"foydali"]],
]])
]);
}

if($data == "oy8" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>Avgust.Erkinlikni xush koʻrishadi. Oʻziga xon – koʻlankasi maydon, boʻlib yurishni istaydi doim. Shu sabab oʻsmirligi ota-onalar bilan muammolar kuzatiladi. Omadlari chopishi yanada oʻziga boʻlgan ishonchni oshiradi.</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"foydali"]],
]])
]);
}

if($data == "oy9" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>Sentabr.Kuzning ilk oyida tugʻilgan erkaklarning ham taʼqiqlarga xushi yoʻq.Xolis va ezgulik istovchi boʻlishadi. Manfaat koʻzlamaydigan doʻstdir ular. Faqat birovlarning fikri bilan ish tutishi yaxshimas.</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"foydali"]],
]])
]);
}

if($data == "oy10" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>Oktabr.Oilasining, yaqinlarining tashvishi bilan yonib-kuyadiganlar. Ishonuvchanliklar baʼzida pand berib qoladi. Tuygʻulariga quloq tutishadi. Vafodorliklari esa taxsinga loyiq.</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"foydali"]],
]])
]);
}

if($data == "oy11" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>Noyabr.Ushbu oy vakillari dono, hajviyaga usta va ishning koʻzini biladigan boʻlishadi. Karyera pogonalarining choʻqqisini zabt etishadi. Chunki ular maʼsuliyatli va mehnatkash. Birovlarning manfaatini deb, oʻzining imkoniyatlarini cheklashlari zarariga ishlaydi</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"foydali"]],
]])
]);
}

if($data == "oy12" and joinchat($ccid) == "true"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>Dekabr.Kezi kelganda, juda qattiqqoʻl. Ilm qilishga moyil boʻlishadi. Notanishlar bilan tez til topishishadi. Karyera borasida ham oshigʻi olchi, faqat shuhratga berilib, manmanlik qilishmasa, bas. Jahli chiqqanda, olovga yogʻ sepmay, jim turishingiz shart</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"foydali"]],
]])
]);
}

if($data=="boglanish"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>📝 Murojaat matnini yuboring:</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"menyu"]],
]])
]);
file_put_contents("step/$ccid.txt","murojat");
}

if($userstep=="murojat"){
if($data=="menyu"){
unlink("step/$cid.txt");
}else{
file_put_contents("step/$cid.murojat","$cid");
$murojat=file_get_contents("step/$cid.murojat");
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>📨 Yangi murojat keldi:</b> <a href='tg://user?id=$murojat'>$murojat</a>

<b>📑 Murojat matni:</b> $tx

<b>⏰ Kelgan vaqti:</b> $soat",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"💌 Javob yozish",'callback_data'=>"yozish=$murojat"]],
]])
]);
unlink("step/$murojat.txt");
bot('sendMessage',[
'chat_id'=>$murojat,
'text'=>"<b>✅ Murojaatingiz yuborildi.</b>

<i>Tez orada javob qaytaramiz!</i>",
'parse_mode'=>'html',
]);
}}

if(mb_stripos($data,"yozish=")!==false){
$odam=explode("=",$data)[1];
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>Javob matnini yuboring:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"❌ Ortga Qaytish",'callback_data'=>"menyu"]],
]])
]);
file_put_contents("step/$ccid.txt","javob");
file_put_contents("step/$ccid.javob","$odam");
}

if($userstep=="javob"){
if($data=="menyu"){
unlink("step/$admin.txt");
unlink("step/$admin.javob");
}else{
$murojat=file_get_contents("step/$cid.javob");
bot('sendMessage',[
'chat_id'=>$murojat,
'text'=>"<b>☎️ Administrator:</b>

<i> $tx </i>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"Javob yozish",'callback_data'=>"boglanish"]],
]])
]);
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>Javob yuborildi</b>",
'parse_mode'=>"html",
]);
unlink("step/$murojat.murojat");
unlink("step/$admin.txt");
unlink("step/$admin.javob");
}}

$admin1_menu = json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"📨 Xabar yuborish"]],
[['text'=>"📢 Kanallar"],['text'=>"📊 Statistika"]],
]]);

if($tx == "🗄 Boshqaruv" and $cid == $admin){
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>🗄 Boshqaruv paneliga xush kelibsiz!</b>",
'parse_mode'=>"html",
'reply_markup'=>$admin1_menu
]);
unlink("step/$cid.txt");
unlink("miqdor.txt");
unlink("fbsh.txt");
}

$oddiy_xabar = file_get_contents("oddiy.txt");
if($data == "oddiy_xabar" and $ccid==$admin){
$lich=substr_count($statistika,"\n");
bot('deleteMessage',[
'chat_id'=>$admin,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>$lich ta foydalanuvchiga yuboriladigan xabar matnini yuboring:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"🗄 Boshqaruv"]],
]])
]);
file_put_contents("oddiy.txt","oddiy");
}
if($oddiy_xabar=="oddiy" and $cid==$admin){
if($tx=="🗄 Boshqaruv"){
unlink("oddiy.txt");
}else{
$lich=substr_count($statistika,"\n");
bot('sendmessage',[
'chat_id'=>$admin,
'text'=>"<b>$lich ta foydalanuvchiga xabar yuborish boshlandi!</b>",
'parse_mode'=>"html",
'reply_markup'=>$admin1_menu,
]);
$lichka = explode("\n",$statistika);
foreach($lichka as $lichkalar){
$usr=bot("sendMessage",[
'chat_id'=>$lichkalar,
'text'=>$text,
'parse_mode'=>'HTML'
]);
unlink("oddiy.txt");
}}}
if($usr){
$lich=substr_count($statistika,"\n");
bot("sendmessage",[
'chat_id'=>$admin,
'text'=>"<b>$lich ta foydalanuvchiga muvaffaqiyatli yuborildi</b>",
'parse_mode'=>'html',
'reply_markup'=>$admin1_menu,
]);
unlink("oddiy.txt");
}

$forward_xabar = file_get_contents("forward.txt");
if($data =="forward_xabar" and $ccid==$admin){
$lich=substr_count($statistika,"\n");
bot('deleteMessage',[
'chat_id'=>$admin,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>$lich ta foydalanuvchiga yuboriladigan xabarni forward shaklida yuboring:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"🗄 Boshqaruv"]],
]])
]);
file_put_contents("forward.txt","forward");
}
if($forward_xabar=="forward" and $cid==$admin){
if($tx=="🗄 Boshqaruv"){
unlink("forward.txt");
}else{
$lich=substr_count($statistika,"\n");
bot('sendmessage',[
'chat_id'=>$admin,
'text'=>"<b>$lich ta foydalanuvchiga xabar yuborish boshlandi!</b>",
'parse_mode'=>"html",
'reply_markup'=>$admin1_menu,
]);
$lichka = explode("\n",$statistika);
foreach($lichka as $lichkalar){
$fors=bot("forwardMessage",[
'from_chat_id'=>$cid,
'chat_id'=>$lichkalar,
'message_id'=>$mid,
]);
unlink("forward.txt");
}}}
if($fors){
$lich=substr_count($statistika,"\n");
bot("sendmessage",[
'chat_id'=>$admin,
'text'=>"<b>$lich ta foydalanuvchiga muvaffaqiyatli yuborildi</b>",
'parse_mode'=>'html',
'reply_markup'=>$admin1_menu,
]);
unlink("forward.txt");
}

if($tx=="📨 Xabar yuborish" and $cid==$admin){
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>📨 Yuboriladigan xabar turini tanlang:</b>",
'parse_mode'=>"html",
'reply_markup'=> json_encode([
'inline_keyboard'=>[
[['text'=>"Oddiy xabar",'callback_data'=>"oddiy_xabar"]],
[['text'=>"Forward xabar",'callback_data'=>"forward_xabar"]],
]])
]);
}

$admin6_menu = json_encode([
'inline_keyboard'=>[
[['text'=>"🔐 Majburiy obuna",'callback_data'=>"majburiy_obuna"]],
]]);

if($data=="kanalsoz" and $ccid==$admin){
bot('deleteMessage',[
'chat_id'=>$admin,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>Quyidagilardan birini tanlang:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🔐 Majburiy obuna",'callback_data'=>"majburiy_obuna"]],
]])
]);
unlink("step/$ccid.txt");
}

if($tx == "📊 Statistika" and $cid == $admin){
$lich=substr_count($statistika,"\n");
$load = sys_getloadavg();
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>💡 O'rtacha yuklanish:</b> <code>$load[0]</code>

👥 <b>Foydalanuvchilar: $lich ta</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🔁 Yangilash",'callback_data'=>"stats"]],
]])
]);
}

if($data=="stats" and $ccid == $admin){
$lich=substr_count($statistika,"\n");
$load = sys_getloadavg();
bot('deleteMessage',[
'chat_id'=>$admin,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>💡 O'rtacha yuklanish:</b> <code>$load[0]</code>

👥 <b>Foydalanuvchilar: $lich ta</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🔁 Yangilash",'callback_data'=>"stats"]],
]])
]);
}

if($tx=="📢 Kanallar" and $cid==$admin){
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>Quyidagilardan birini tanlang:</b>",
'parse_mode'=>"html",
'reply_markup'=>$admin6_menu
]);
}

if($data=="majburiy_obuna" and $ccid==$admin){
bot('editMessageText',[
'chat_id'=>$admin,
'message_id'=>$cmid,
'text'=>"<b>Majburiy obunalarni sozlash bo'limidasiz:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"📋 Ro'yxatni ko'rish",'callback_data'=>"majburiy_obuna3"]],
[['text'=>"➕ Kanal qo'shish",'callback_data'=>"majburiy_obuna1"],['text'=>"🗑 O'chirish",'callback_data'=>"majburiy_obuna2"]],
[['text'=>"◀️ Orqaga",'callback_data'=>"kanalsoz"]],

]])
]);
unlink("step/$cid.txt");
}

$majburiy = file_get_contents("maj.txt");
if($data=="majburiy_obuna1" and $ccid == $admin){
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>📢 Kerakli kanalni manzilini yuboring:</b>

Namuna: @Editphp",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"🗄 Boshqaruv"]],
]])
]);
file_put_contents("maj.txt","majburiy1");
}
if($majburiy == "majburiy1" and $cid==$admin){
if($tx=="🗄 Boshqaruv"){
unlink("maj.txt");
}else{
if(stripos($text,"@")!==false){
if($kanallar == null){
file_put_contents("channel.txt",$text);
bot('SendMessage',[
'chat_id'=>$admin,
'text'=>"<b>$text - kanal qo'shildi</b>",
'parse_mode'=>'html',
'reply_markup'=>$admin1_menu,
]);
unlink("maj.txt");
}else{
file_put_contents("channel.txt","$kanallar\n$text");
bot('SendMessage',[
'chat_id'=>$admin,
'text'=>"<b>$text - kanal qo'shildi</b>",
'parse_mode'=>'html',
'reply_markup'=>$admin1_menu,
]);
unlink("maj.txt");
}}else{
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"<b>⚠️ Kanal manzili kiritishda xatolik:</b>

Masalan: @Editphp",
'parse_mode'=>'html',
]);
}}}

if($data=="majburiy_obuna2" and $ccid == $admin){
bot('deleteMessage',[
'chat_id'=>$admin,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>🗑 Kanallar o'chirildi!</b>",
'parse_mode'=>"html",
]);
unlink("channel.txt");
}

if($data=="majburiy_obuna3" and $ccid==$admin){
if($kanallar==null){
bot('editMessageText',[
'chat_id'=>$admin,
'message_id'=>$cmid,
'text'=>"<b>Kanallar ulanmagan!</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"◀️ Orqaga",'callback_data'=>"majburiy_obuna"]],
]])
]);
}else{
$soni = substr_count($kanallar,"@");
bot('editMessageText',[
'chat_id'=>$admin,
'message_id'=>$cmid,
'text'=>"<b>Ulangan kanallar ro'yxati ⤵️</b>
➖➖➖➖➖➖➖➖

<i>$kanallar</i>

<b>Ulangan kanallar soni:</b> $soni ta",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"◀️ Orqaga",'callback_data'=>"majburiy_obuna"]],
]])
]);
}}

if($tx=="/panel" and $cid==$admin){
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"🖥",
'reply_markup'=>$admin1_menu,
]);
unlink("admin/$cid.txt");
unlink("fbsh.txt");
}
?>
