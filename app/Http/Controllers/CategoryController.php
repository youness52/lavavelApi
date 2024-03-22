<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Category;
use Validator;
//header('Access-Control-Allow-Origin: *'); 
class CategoryController extends Controller
{
	public function index(){
		return view('Category.index');
	}

	public function list(){
		$categories = Category::get();
		return response()->json(['status' => true, 'data' => $categories ]);
	}

	public function save(Request $request, $id = ""){
		$validator = Validator::make($request->all(), [
			'name' => 'required',
		]);

		if($validator->fails()){
			return response()->json(['status' => false, 'error' => $validator->errors() ]);
		}else{
			if(!empty($id)){
				$categories = Category::where('id', $id)->update([
					'name' => $request->get('name'),
				]);
				if($categories){
					return response()->json(['status' => true, 'message' => 'categories saved successfully!']);
				}
			}else{
				$categories = Category::create([
					'name' => $request->get('name'),
				]);
				if($categories){
					return response()->json(['status' => true, 'message' => 'categories updated successfully!']);
				}
			}
		}
	}

	public function find($id){
		$categories = Category::findOrFail($id);
		return response()->json(['status' => true, 'data' => $categories ]);
	}

	public function delete($id){
		$categories = Category::findOrFail($id);
		if($categories->delete()){
			return response()->json(['status' => true, 'message' => 'Record deleted successfully!' ]);
		}
	}

}