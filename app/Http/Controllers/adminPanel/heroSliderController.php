<?php

namespace App\Http\Controllers\adminPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class heroSliderController extends Controller
{
    public function index()
    {
        $sliders = DB::table('hero_sliders')
            ->orderBy('order', 'asc')
            ->get();
        
        return view('adminPanel.heroSlider.index', compact('sliders'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg|max:5120', // 5MB max
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Get max order
        $maxOrder = DB::table('hero_sliders')->max('order') ?? 0;

        // Upload image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $imagePath = public_path('assets/img/hero_slider/');
            
            if (!is_dir($imagePath)) {
                mkdir($imagePath, 0777, true);
            }
            
            $image->move($imagePath, $imageName);
            
            DB::table('hero_sliders')->insert([
                'image' => $imageName,
                'order' => $maxOrder + 1,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('admin.heroSlider.index')
            ->with('success', 'Fotoğraf başarıyla eklendi.');
    }

    public function destroy($id)
    {
        $slider = DB::table('hero_sliders')->where('id', $id)->first();
        
        if ($slider) {
            // Delete image file
            $imagePath = public_path('assets/img/hero_slider/' . $slider->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            
            DB::table('hero_sliders')->where('id', $id)->delete();
        }

        return redirect()->route('admin.heroSlider.index')
            ->with('success', 'Fotoğraf başarıyla silindi.');
    }

    public function updateOrder(Request $request)
    {
        $orders = $request->input('orders', []);
        
        foreach ($orders as $index => $id) {
            DB::table('hero_sliders')
                ->where('id', $id)
                ->update(['order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }
}

