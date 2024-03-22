<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Category;
use Validator;

class ProductController extends Controller
{
	public function index(){
		return view('Product.index');
	}

	public function list(){
		
		//$products = Product::get();
		$products = DB::select('SELECT `products`.*, `categories`.`name` as category_name FROM `products` , `categories` where products.category_id=categories.id;');
		return response()->json(['status' => true, 'data' => $products ]);
	}

	public function save(Request $request, $id = ""){
		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'description' => 'required',
			'price' => 'required',
			'quantity' => 'required',
			'others' => 'required',
			'category_id' => 'required',
		]);

		if($validator->fails()){
			return response()->json(['status' => false, 'error' => $validator->errors() ]);
		}else{
			if(!empty($id)){
				$products = Product::where('id', $id)->update([
					'name' => $request->get('name'),
					'description' => $request->get('description'),
					'price' => $request->get('price'),
					'quantity' => $request->get('quantity'),
					'others' => $request->get('others'),
					'category_id' => $request->get('category_id'),
				]);
				if($products){
					return response()->json(['status' => true, 'message' => 'products saved successfully!']);
				}
			}else{
				$products = Product::create([
					'name' => $request->get('name'),
					'description' => $request->get('description'),
					'price' => $request->get('price'),
					'quantity' => $request->get('quantity'),
					'others' => $request->get('others'),
					'category_id' => $request->get('category_id'),
				]);
				if($products){
					return response()->json(['status' => true, 'message' => 'products updated successfully!']);
				}
			}
		}
	}

	public function find($id){
		$products = Product::findOrFail($id);
		return response()->json(['status' => true, 'data' => $products ]);
	}
    public function create(){
		$products = Category::get();
		return response()->json(['status' => true, 'data' => $products ]);
	}

	public function delete($id){
		$products = Product::findOrFail($id);
		if($products->delete()){
			return response()->json(['status' => true, 'message' => 'Record deleted successfully!' ]);
		}
	}

}