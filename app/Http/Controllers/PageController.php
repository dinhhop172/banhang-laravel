<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Slide;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

use function Ramsey\Uuid\v1;

class PageController extends Controller
{
    function getIndex(){
        $slide = Slide::all();
        $new_product = Product::where('new', 1)->paginate(4);
        $sp_khuyenmai = Product::where('promotion_price','<>', 0)->paginate(8);
        return view('page.trangchu', compact('slide', 'new_product', 'sp_khuyenmai'));
    }

    function getLoaisp($type){
        $sp_theoloai = Product::where('id_type', $type)->get();
        $sp_khac = Product::where('id_type', '<>', $type)->paginate(3);
        $loai = ProductType::all();
        $loai_sp = ProductType::where('id', $type)->first();
        return view('page.loai_sanpham', compact('sp_theoloai', 'sp_khac', 'loai', 'loai_sp'));
    }

    function getChitiet(Request $req){
        $sanpham = Product::where('id', $req->id)->first();
        $sp_tuongtu = Product::where('id_type', $sanpham->id_type)->paginate(6);
        return view('page.chitiet_sanpham', compact('sanpham', 'sp_tuongtu'));
    }

    function getLienhe(){
        return view('page.lienhe');
    }

    function getGioithieu(){
        return view('page.gioithieu');
    }

    public function getAddtoCart(Request $req, $id){
        $product = Product::find($id);
        $oldCart = Session('cart')?Session::get('cart'):null;
        $cart = new Cart($oldCart);
        $cart->add($product, $id);
        $req->session()->put('cart', $cart);
        return redirect()->back();
    }

    public function getDelItemCart($id){
        $oldCart = Session::has('cart')?Session::get('cart'):null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);
        if(count($cart->items)>0){
            Session::put('cart', $cart);
        }
        else{
            Session::forget('cart');
        }
        return redirect()->back();
    }

    public function getCheckout(){
        return view('page.dat_hang');
    }

    public function postCheckout(Request $req){

    }

    public function getLogin(){
        return view('page.dangnhap');
    }

    public function getSignin(){
        return view('page.dangky');
    }

    public function postSignin(Request $req){
        $this->validate($req,
            [
                'email'=>'required|email|unique:users,email',
                'password'=>'required|min:6|max:20',
                'fullname'=>'required',
                're_password'=>'required|same:password',
            ],
            [
                'email.required'=>'Vui lòng nhập email',
                'email.email'=>'Không đúng định dạng email',
                'email.unique'=>'Email đã có người sử dụng',
                'password.required'=>'Vui lòng nhập mật khẩu',
                're_password.same'=>'Mật khẩu không giống nhau',
                'password.min'=>'Mật khẩu ít nhất 6 ký tự',
            ]);

            $user = new User();
            $user->full_name = $req->fullname;
            $user->email = $req->email;
            $user->password = Hash::make($req->password);
            $user->phone = $req->phone;
            $user->address = $req->address;
            $user->save();
            return redirect()->back()->with('thanhcong', 'Tạo tài khoản thành công');
    }

    public function postLogin(Request $request){
        $this->validate($request,
            [
                'email'=>'required|email',
                'password'=>'required|min:6|max:20'
            ],
            [
                'email.required'=>'Vui lòng nhập email',
                'email.email'=>'Email không đúng định dạng',
                'password.required'=>'Vui lòng nhập password',
                'password.min'=>'Mật khẩu tối thiểu 6 ký tự',
                'password.max'=>'Mật khẩu tối đa 20 ký tự',
            ]
        );
        $credentials = array('email'=>$request->email, 'password'=>$request->password);
        if(Auth::attempt($credentials)){
            return redirect()->back()->with(['flag'=>'success', 'message'=> 'Đăng nhập thành công']);
        }else{
            return redirect()->back()->with(['flag'=>'danger', 'message'=> 'Đăng nhập không thành công']);
        }
    }

    public function postLogout(){
        Auth::logout();
        return redirect()->route('trang-chu');
    }

    public function getSearch(Request $request){
        $product = Product::where('name', 'like', '%'.$request->key.'%')
                            ->orWhere('unit_price', $request->key)
                            ->get();
                return view('page.search', compact('product'));
    }
}
