<?php

namespace App\Http\Controllers\Auther;

use App\Http\Controllers\Controller;
use App\Models\Auther;
use App\Models\AutherHistory;
use App\Models\News;
use App\Models\TrendingCategory;
use App\Models\TrendingNews;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Mail;
use Session;
use Validator;

class AutherController extends Controller
{
    public function becomeAuther(Request $request)
    {
        $valid = Validator::make($request->all(), ['name' => "required", "mobile_no" => "required", "email" => "required"]);
        if ($valid->passes()) {
            if ($request->blog_link || $request->social_link) {
                $auther = Auther::where('email', $request->email)->get()->first();
                if ($auther) {
                    return response()->json([
                        'status' => false,
                        'msg' => "Your Request Already Send TO The Admin!!",
                    ]);
                }
                $auther = new Auther();
                $auther->auther_id = "auther_" . rand(1111111111, 9999999999);
                $auther->name = $request->name;
                $auther->email = $request->email;
                $auther->mobile_no = $request->mobile_no;
                if ($request->blog_link) {
                    $auther->blog_article = $request->blog_link;
                }
                if ($request->social_link) {
                    $auther->social_link = $request->social_link;
                }
                $auther->save();
                return response()->json([
                    'status' => true,
                    'msg' => "Your Request Send To The Admin!!",
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'msg' => "Enter Social Link Or Blog Link!",
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'msg' => $valid->errors()->all(),
            ]);
        }
    }

    public function autherLogin(Request $request)
    {
        $valid = Validator::make($request->all(), ["email" => "required", "password" => "required"]);
        if ($valid->passes()) {
            $auther = Auther::where(['email' => $request->email, "approved" => 1])->get()->first();
            if ($auther) {
                if (Hash::check($request->password, $auther->password)) {
                    Session::put('autherEmail', $request->email);
                    Session::put('autherName', $auther->name);
                    Session::put('amount', $auther->amount);
                    return response()->json([
                        'status' => true,
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'msg' => "Enter Correct Password!!",
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'msg' => "Enter Registered Email or You are not approved by Admin!!",
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'msg' => $valid->errors()->all(),
            ]);
        }
    }

    public function login()
    {
        $email = Session::get('autherEmail');
        if ($email) {
            return Redirect::to(url('/auther/dashboard'));
        }
        return view('writer.login');
    }

    public function logout()
    {
        session()->forget('autherEmail');
        session()->forget('autherName');
        return Redirect::to('/auther/auther-login');
    }

    public function dashboard()
    {
        $email = Session::get('autherEmail');
        $auther_id = Auther::where('email', $email)->get()->first()->auther_id;
        $auther_news = TrendingNews::orderby('id', 'desc')->where('writtenBy', $auther_id)->take(10)->get();
        $news = News::orderby('id', 'desc')->where('writtenBy', $auther_id)->take(5)->get();
        $arr = array();
        foreach ($auther_news as $value) {
            array_push($arr, $value);
        }
        foreach ($news as $key => $value) {
            array_push($arr, $value);
        }
        return view('writer.dashboard', ['trendingNews' => $arr]);
    }

    public function writeNews()
    {
        $data['categories'] = ['national', 'business', 'sports', 'world', 'politics', 'technology', 'startup', 'entertainment', 'miscellaneous', 'hatke', 'automobile', "others"];
        $data['trenndingCategories'] = TrendingCategory::orderby('id', 'desc')->get();
        return view('writer.writenews', $data);
    }

    public function submitPost(Request $request)
    {
        $valid = Validator::make($request->all(), ["title" => "required", "img" => "required", "description" => "required", "sourceURL" => "required"]);
        if ($valid->passes()) {
            $arr = explode(' ', $request->description);
            if (count($arr) > 70) {
                Session::put('title', $request->title);
                Session::put('description', $request->description);
                return Redirect::to(url('/auther/writeNews?msg=Enter Maximum 70 words!!'));
            }
            if ($request->category || $request->trendingCategory) {
                date_default_timezone_set("Asia/kolkata");
                $time = date('h:i a');
                $date = date('d M');
                $postedAt = $time . " " . $date;
                $auther_email = Session::get('autherEmail');
                $auther = Auther::where('email', $auther_email)->get()->first();
                $img = $request->file('img');
                $extension = $img->getClientOriginalExtension();
                $imgname = time() . rand(11111, 99999) . "." . $extension;
                $path = $img->move('public/uploads/news', $imgname);
                if ($request->category) {
                    $id = News::get()->count();
                    $add_new_news = new News();
                    $add_new_news->id = "news_" . $id + 1;
                    $add_new_news->category = $request->category;
                    $add_new_news->title = $request->title;
                    $add_new_news->author = $auther->name;
                    $add_new_news->content = $request->description;
                    $add_new_news->postedAt = $postedAt;
                    $add_new_news->sourceURL = $request->sourceURL;
                    $add_new_news->imgsrc = $path;
                    $add_new_news->writtenBy = $auther->auther_id;
                    $add_new_news->save();
                    session()->forget('title');
                    session()->forget('description');
                    return Redirect::to(url('/auther/writeNews'));
                }
                if ($request->trendingCategory) {
                    $id = TrendingNews::get()->count();
                    $add_new_news = new TrendingNews();
                    $add_new_news->id = "trending_" . $id + 1;
                    $add_new_news->category = $request->trendingCategory;
                    $add_new_news->title = $request->title;
                    $add_new_news->author = $auther->name;
                    $add_new_news->content = $request->description;
                    $add_new_news->postedAt = $postedAt;
                    $add_new_news->sourceURL = $request->sourceURL;
                    $add_new_news->imgsrc = url('/' . $path);
                    $add_new_news->writtenBy = $auther->auther_id;
                    $add_new_news->save();
                    session()->forget('title');
                    session()->forget('description');
                    return Redirect::to(url('/auther/writeNews'));
                }
            } else {
                Session::put('title', $request->title);
                Session::put('description', $request->description);
                return Redirect::to(url('/auther/writeNews?msg=Select Category or or Trending Category'));
            }
        } else {
            $error = implode(',', $valid->errors()->all());
            Session::put('title', $request->title);
            Session::put('description', $request->description);
            return Redirect::to(url('/auther/writeNews?msg=' . $error));
        }
    }

    public function changepassword()
    {
        return view('writer.changepassword');
    }
    public function changePasswordProcess(Request $request)
    {
        $valid = Validator::make($request->all(), ["new_password" => "required", "cnf_password" => "required"]);
        if ($valid->passes()) {
            if ($request->new_password == $request->cnf_password) {
                $auther = Auther::where(['email' => Session::get('autherEmail'), 'approved' => 1])->get()->first();
                $auther->password = Hash::make($request->new_password);
                $auther->save();
                return response()->json([
                    'status' => true,
                    'msg' => "Password Changed Successfully!!",
                ]);

            } else {
                return response()->json([
                    'status' => false,
                    'msg' => "Enter Both Password Same!!",
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'msg' => $valid->errors()->all(),
            ]);
        }
    }

    public function forgetPassword(Request $request)
    {
        $auther = Auther::where('email', $request->email)->get()->first();
        if ($auther) {
            $to_name = $auther->name;
            $to_email = $auther->email;
            $data = ['name' => $to_name, "email" => md5($auther->email)];
            Mail::send('emails.forgotPasswordEmail', $data, function ($message) use ($to_name, $to_email) {
                $message->to($to_email, $to_name)
                    ->subject('Forgot Password Email');
                $message->from('funtoos456@gmail.com', 'Instant News');
            });
            return response()->json([
                'status' => true,
                'msg' => "Email Send To Your Registered Email.",
            ]);
        } else {
            return response()->json([
                'status' => false,
                'msg' => "Something Went Wrong. Try Again!!",
            ]);
        }

    }

    public function forgetPasswordProcess($email)
    {
        $auther = Auther::where('approved', 1)->get();
        // dd($auther);
        foreach ($auther as $key => $value) {
            if (md5($value->email) == $email) {
                return view('writer.forgetPasswordProcess');
            }
        }
        return Redirect::to(url('/error'));
    }

    public function changeForgetPassword(Request $request)
    {
        $valid = Validator::make($request->all(), ['new_password' => "required", "cnf_password" => "required"]);
        if ($valid->passes()) {
            if ($request->new_password == $request->cnf_password) {
                $auther = Auther::where('approved', 1)->get();
                foreach ($auther as $key => $value) {
                    if (md5($value->email) == $request->email) {
                        $value->password = Hash::make($request->cnf_password);
                        $value->save();
                        return response()->json([
                            'status' => true,
                            'msg' => "Your Password Changed!!",
                        ]);
                    }
                }
                return response()->json([
                    'status' => false,
                    'msg' => "Something Went Wrong",
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'msg' => "Enter Both Password Same!!",
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'msg' => $valid->errors()->all(),
            ]);
        }
    }

    public function coins()
    {
        return view('writer.coins');
    }

    public function getAutherHistory($page)
    {
        $auther_id = Auther::where('email', Session::get('autherEmail'))->get()->first()->auther_id;
        $history = AutherHistory::orderby('id', 'desc')->where('auther_id', $auther_id)->get();
        $arr = array();
        $categories = ['national', 'business', 'sports', 'world', 'politics', 'technology', 'startup', 'entertainment', 'miscellaneous', 'hatke', 'automobile'];
        foreach ($history as $key => $value) {
            if (in_array($value->category, $categories)) {
                $news = News::where('id', $value->news_id)->get()->first();
            } else {
                $news = TrendingNews::where('id', $value->news_id)->get()->first();
            }
            $arr2 = explode(',', $news->likes);
            $arr1 = array('category' => $value->category, "title" => $news->title, "content" => $news->content, "likes" => count($arr2) - 1, "amount" => $value->amount);
            array_push($arr, $arr1);
        }
        $arr4 = collect($arr)->forPage($page, 5);
        $data = array();
        foreach ($arr4 as $key => $value) {
            array_push($data, $value);
        }
        if (count($arr)) {
            return response()->json([
                'status' => true,
                'data' => $data,
            ]);
        } else {
            return response()->json([
                'status' => false,
                "msg" => "No Data Found!!",
            ]);
        }
    }

    public function withdrawProcess(Request $request)
    {
        $valid = Validator::make($request->all(), ["mode" => "required", "mobile_no" => "required", "amount" => "required"]);
        if ($valid->passes()) {
            if ($request->amount < 50) {
                return response()->json([
                    'status' => false,
                    'msg' => "Minimum Amount Transfer is 50rs!!",
                ]);
            }
            $auther = Auther::where('email', Session::get('autherEmail'))->get()->first();
            if ($auther && ($auther->amount >= $request->amount)) {
                $auther->amount = $auther->amount - $request->amount;
                $auther->save();
                $withdraw = new Withdraw();
                $withdraw->auther_id = $auther->auther_id;
                $withdraw->name = $auther->name;
                $withdraw->mode = $request->mode;
                $withdraw->mobile_no = $request->mobile_no;
                $withdraw->amount = $request->amount;
                $withdraw->save();
                return response()->json([
                    'status' => true,
                    'msg' => "Your Amount Credited to your bank in 12 hours!!",
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'msg' => "Insufficient Balance!!",
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'msg' => $valid->errors()->all(),
            ]);
        }
    }

}
