<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Shop;
use App\Models\Reservation;
use App\Models\Review;
use App\Http\Requests\ReservationRequest;
use App\Http\Requests\ShopRequest;
use Carbon\Carbon;
use App\Mail\AdminSend;
use Illuminate\Support\Facades\Mail;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use Illuminate\Support\Facades\Storage;

class ShopController extends Controller
{
    public function index(Request $request){
        $areas = Area::all();
        $genres = Genre::all();
        $query = Shop::query();
        if($request->area !== "all" && $request->has('area')){
            $query->where('area_id', $request->query('area'));
        }
        if($request->genre !== "all" && $request->has('genre')){
            $query->where('genre_id', $request->query('genre'));
        }
        if($request->search !== "" && $request->has('search')){
            $query->where(function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->query('search') . '%')
                ->orWhere('description', 'LIKE', '%' . $request->query('search') . '%');
            });
        }
        $shops = $query->get();

        $request->session()->put('previous_query', $request->query());

        return view('shop-all', compact('shops', 'areas', 'genres'));
    }

    public function like(Request $request,$id){
        $user = auth()->user();

        // いいねの追加または解除
        if ($user->shops()->where('shop_id', $id)->exists()) {
            $user->shops()->detach($id);
        } else {
            $user->shops()->attach($id);
        }    
            
            $previousQuery = $request->session()->get('previous_query', []);
    
            if(array_key_exists('area',$previousQuery)){
                $area = $previousQuery['area'];
            }else{
                $area = 'all';
            }
            if(array_key_exists('genre',$previousQuery)){
                $genre = $previousQuery['genre'];
            }else{
                $genre = 'all';
            }
            if(array_key_exists('search',$previousQuery)){
                $search = $previousQuery['search'];
            }else{
                $search = '';
            }

            return redirect("/?area=$area&genre=$genre&search=$search");
    }

    public function detail(Request $request,$id){
        $shop = Shop::findOrFail($id);

        if($request->input("from") == "index"){
            $request->session()->put('jump_from','index');
        }
        elseif($request->input("from") == "mypage"){
            $request->session()->put('jump_from','mypage');
        }
        elseif($request->input("from") == "control"){
            $request->session()->put('jump_from','control');
        }

        return view('shop-detail',compact('shop'));
    }

    public function back(Request $request){
        $previousQuery = $request->session()->get('previous_query', []);
        //dd($previousQuery);
        if(array_key_exists('area',$previousQuery)){
            $area = $previousQuery['area'];
        }else{
            $area = 'all';
        }
        if(array_key_exists('genre',$previousQuery)){
            $genre = $previousQuery['genre'];
        }else{
            $genre = 'all';
        }
        if(array_key_exists('search',$previousQuery)){
            $search = $previousQuery['search'];
        }else{
            $search = '';
        }

        $from = $request->session()->get('jump_from',"");

        if($from == "index"){
            return redirect("/?area=$area&genre=$genre&search=$search");
        }
        if($from == "mypage"){
            return redirect('/mypage');
        }
        if($from == "control"){
            return redirect('/control');
        }
        else{
            return redirect('/');
        }
    }

    public function reserve(ReservationRequest $request,$id){
        $carbon_set = new Carbon("$request->date $request->time",'Asia/Tokyo');
        $carbon_now = Carbon::now('Asia/Tokyo');
        
        if($carbon_set->lte($carbon_now)){
            $shop = Shop::findOrFail($id);
            return redirect("/detail/$id")->with(compact('shop'))->with('please_set_later','過去の日時が選択されています');
        }

        $reservation = Reservation::create([
            'user_id' => auth()->user()->id,
            'shop_id' => $id,
            'date' => $request->date,
            'time' => $request->time,
            'number' => $request->number,
            'visited' => 'no',
            'reviewed' => 'no',
            'reminded' => 'no',
            'qr_code_data' => uniqid(),
        ]);

        //$fileName = "qr_codes/$reservation->qr_code_data.png";
        //$reservation->update(['qr_code_data' => $fileName]);

        $shop = Shop::findOrFail($id);

        return view('done',compact('shop'));
    }

    public function mypage(){
        $user = auth()->user();
        $not_reviewed_reservations  = Reservation::where('reviewed','no')->get();

        return view('mypage',compact('user','not_reviewed_reservations'));
    }

    public function change(ReservationRequest $request,$id){
        $carbon_set = new Carbon("$request->date $request->time",'Asia/Tokyo');
        $carbon_now = Carbon::now('Asia/Tokyo');
        
        if($carbon_set->lte($carbon_now)){
            $user = auth()->user();
            $not_reviewed_reservations  = Reservation::where('reviewed','no')->get();
            return redirect("/mypage")->with(compact('user','not_reviewed_reservations'))->with('please_set_later','過去の日時が選択されています');
        }

        $reservation = Reservation::findOrFail($id)
        ->update([
            'date' => $request->date,
            'time' => $request->time,
        ]);

        return redirect('mypage');
    }

    public function delete(Request $request,$id){
        $reservation = Reservation::findOrFail($id)
        ->delete();

        return redirect('mypage');
    }

    public function likeOnMypage(Request $request,$id){
        $user = auth()->user();

        if ($user->shops()->where('shop_id', $id)->exists()) {
            $user->shops()->detach($id);
        } else {
            $user->shops()->attach($id);
        }    

        $previousQuery = $request->session()->get('previous_query', []);
            //dd($previousQuery);
        if(array_key_exists('area',$previousQuery)){
            $area = $previousQuery['area'];
        }else{
            $area = 'all';
        }
        if(array_key_exists('genre',$previousQuery)){
            $genre = $previousQuery['genre'];
        }else{
            $genre = 'all';
        }
        if(array_key_exists('search',$previousQuery)){
            $search = $previousQuery['search'];
        }else{
            $search = '';
        }

        return redirect("/mypage");
    }

    public function control(){
        $user = auth()->user();

        return view('control',compact('user'));
    }

    public function create(ShopRequest $request){
        if(Area::where('name',"$request->area")->exists()){
            $area = Area::where('name',"$request->area")->first();
        }else{
            $area = Area::create([
                'name' => $request->area,
            ]);
        }

        if(Genre::where('name',"$request->genre")->exists()){
            $genre = Genre::where('name',"$request->genre")->first();
        }else{
            $genre = Genre::create([
                'name' => $request->genre,
            ]);
        }

        Shop::create([
            'user_id' => auth()->id(),
            'area_id' => $area->id,
            'genre_id' => $genre->id,
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect('control');
    }

    public function goUpdate(Request $request,$id){
        $shop = Shop::findOrFail($id);

        if($request->input("from") == "control"){
            $request->session()->put('jump_from','control');
        }else{
            $request->session()->put('jump_from','');
        }

        return view('shop-update',compact('shop'));
    }

    public function update(ShopRequest $request){
        if(Area::where('name',"$request->area")->exists()){
            $area = Area::where('name',"$request->area")->first();
        }else{
            $area = Area::create([
                'name' => $request->area,
            ]);
        }

        if(Genre::where('name',"$request->genre")->exists()){
            $genre = Genre::where('name',"$request->genre")->first();
        }else{
            $genre = Genre::create([
                'name' => $request->genre,
            ]);
        }

        $shop =Shop::findOrFail($request->id)
        ->update([
            'name' => $request->name,
            'area_id' => $area->id,
            'genre_id' => $genre->id,
            'description' => $request->description,
        ]);
        
        return redirect('/control');
    }

    public function goConfirm(Request $request,$id){
        $not_visited_reservations = Reservation::where('shop_id',$id)
        ->where('visited','no')->get();

        if($request->input("from") == "control"){
            $request->session()->put('jump_from','control');
        }else{
            $request->session()->put('jump_from','');
        }

        return view('confirm-reservation',compact('not_visited_reservations'));
    }

    public function goReview(Request $request,$id){
        $reservation = Reservation::findOrFail($id);

        if($request->input("from") == "mypage"){
            $request->session()->put('jump_from','mypage');
        }else{
            $request->session()->put('jump_from','');
        }

        return view('review',compact('reservation'));
    }

    public function review(Request $request){
        Review::create([
            'user_id' => auth()->id(),
            'shop_id' => $request->shop_id,
            'rating' => $request->rating,
            'content' => $request->content
        ]);

        Reservation::findOrFail($request->reservation_id)
        ->update([
            'reviewed' => 'yes',
        ]);

        return redirect(route('mypage'));
    }

    public function send(Request $request){
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string|max:300',
        ]);

        $users = User::where('role_id',2)
                 ->orWhere('role_id',3)
                 ->get();
        //dd($users);
        foreach ($users as $user) {
            Mail::to($user->email)->send(new AdminSend($request->title, $request->content));
        }

        return redirect('/control')->with('success_send','メールの送信に成功しました');
    }

    public function verifyQrCode(Request $request)
    {
    // スキャンしたQRコードデータを取得
    $qrCodeData = $request->input('qr_code_data'); // 例: uniqid() など

    // QRコードデータを使って予約を照合
    $reservation = Reservation::where('qr_code_data', $qrCodeData)->first();

    if ($reservation) {
        // 来店確認処理を行う
        return response()->json([
            'message' => '来店確認完了',
            'reservation' => $reservation
        ]);
    }

    return response()->json(['message' => '無効なQRコード'], 404);
    }
}
