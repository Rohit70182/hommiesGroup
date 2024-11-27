<?php

namespace Modules\Services\Http\Controllers;

use App\Models\ProviderServices;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Modules\Services\Entities\Category;
use Modules\Services\Entities\Service;
use Modules\Services\Entities\SubCategory;
use Modules\BookService\Entities\Booking;
use Modules\Services\Entities\SubService;
use Illuminate\Support\Facades\DB;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $services = Service::orderBy('id', 'DESC')->paginate(10);
        return view('services::management.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $category = Category::where('state_id', Category::STATE_ACTIVE)->get();
        $data = Service::getServiceTypeAttribute();
        return view('services::management.form', compact('category', 'data'));
    }

    public function get_category($id)
    {
        $data = Subcategory::where('category_id', $id)
                            ->where('state_id', SubCategory::STATE_ACTIVE)
                            ->get();
        return response()->json($data);
    }
    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'name' => 'required',
            'desc' => 'required',
            'category_id' => 'required|integer',
            'subCategory' => 'required|integer',
            'price' => 'nullable|numeric|max:10000000|gt:0',
            'image' => 'required|mimes:jpeg,png,jpg|max:2048',
            'type' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return  Redirect::back()->withInput()->withErrors($validator);
        }
        $service = new Service();
        $service->name = $request->input('name');
        $service->desc = $request->input('desc');
        $service->category_id = $request->input('category_id');
        $service->subcategory_id = $request->input('subCategory');
        $service->price = $request->input('price');
        $service->state_id = Service::STATE_ACTIVE;
        $service->type = $request->input('type');
        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extenstion;
            $file->move('public/uploads', $filename);
            $service->image = $filename;
        }
        if ($service->save()) {
            return redirect('services/')->with('success', 'Service saved succesfully');
        } else {
            return redirect('services/')->with('error', 'Service not saved');
        }
    }


    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $service = Service::find($id);
        return view('services::management.view', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $service = Service::where('id', $id)->first();
        $categoryData = Category::get();
        $subCategory = SubCategory::where('category_id',$service->category_id)->get();  
        return view('services::management.edit', compact('service', 'categoryData', 'subCategory'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
      
        $validator = validator($request->all(), [
            'name' => 'required',
            'desc' => 'required',
            'category_id' => 'required',
            'subcategory_id' => 'required|integer',
            'price' => 'nullable|numeric|max:10000000|gt:0',
            'state_id' => 'nullable|integer',
            'image' => 'mimes:jpeg,png,jpg|max:2048',

        ]);
        if ($validator->fails()) {
        
            return  Redirect::back()->withInput()->withErrors($validator);
        }
        $service = Service::where('id', $id)->first();
      
        $service->name = $request->input('name');
        $service->desc = $request->input('desc');
        $service->category_id = $request->input('category_id');
        $service->subcategory_id = $request->input('subcategory_id');
        
        if($service->state_id == Service::STATE_INACTIVE)
        {
            $service->state_id = Service::STATE_ACTIVE;
            $service->subServices()->update(['state_id' => Service::STATE_ACTIVE]);
        }
        else
        {
            $service->state_id = Service::STATE_INACTIVE;
            $service->subServices()->update(['state_id' => Service::STATE_INACTIVE]);
        }
        
        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extenstion;
            $file->move('public/uploads', $filename);
            $service->image = $filename;
        }
    
        if ($service->save()) {
            return redirect('services/show/'.$id)->with('success', 'Service updated succesfully');
        } else {
            return redirect('services/show/'.$id)->with('error', " Service couldn't be updated");
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $service = Service::where('id', $id)->first();
        $booking = Booking::where('service_id', $id)->first();
        if(!empty($booking))
        {
            return redirect()->back()->with('error', "Service can't be deleted as the service has been booked");
        } else {
            $service->delete();
            $getServices = ProviderServices::where('service_id',$id)->delete();

            return redirect('services/')->with('success', 'Service deleted successfully');
        }
        
    }
    
    
    public function softDelete($id)
    {
        
        try
        {
            $service = Service::where('id', $id)->first();

            if($service->state_id != Service::STATE_INCOMPLETE)
            {

                if($service->state_id == Service::STATE_INACTIVE)
                {
                    $service->state_id = Service::STATE_ACTIVE;
                    $service->subServices()->update(['state_id' => Service::STATE_ACTIVE]);
                }
                else
                {
                    $service->state_id = Service::STATE_INACTIVE;
                    $service->subServices()->update(['state_id' => Service::STATE_INACTIVE]);
                }
                if($service->save())
                {
                    return redirect()->back()->with('success', "State changed successfully");
                }
            }else
            {
                return redirect()->back()->with('success', "State can't be changed as the service is Incomplete");
            }
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with($e->getMessage());
        }
    }
    
    public function changeState($id)
    {
        $service = Service::find($id)->first();
        if ($service->state_id == Service::STATE_ENABLE) {
            $service->state_id = Service::STATE_DISABLE;
        } else {
            $service->state_id = Service::STATE_ENABLE;
        }
        if ($service->update()) {
            return redirect()->back()->with('success', 'State Changed successfully');
        } else {
            return redirect()->back()->with('error', "State couldn't be changed");
        }
    }

    public function home()
    {
        return view('services::index');
    }
    
    public function createSubService($id) {
        
        $serviceID = $id;

        $service = Service::find($id);
        if(!$service->state_id == Service::STATE_INACTIVE){
        return view('services::sub-service.form', compact('serviceID'));
        }
        else{
            return  Redirect::back()->with('error', 'Please Activate your Service To Create A Sub Service');
        }
    }
    
    public function storeSubService(Request $request) {
        
        $validator = validator($request->all(), [
            'name' => 'required',
            'desc' => 'required',
            
        ]);
        
        if ($validator->fails()) {
            return  Redirect::back()->withInput()->withErrors($validator);
        }
        
        $serviceID = $request->service_id;
        $subName = $request->name;
        $subDesc = $request->desc;
        $subService = new SubService();
        $subService->service_id = $serviceID;
        $subService->sub_service_name = $subName;
        $subService->description = $subDesc;
        $subService->state_id = Service::STATE_ACTIVE;
        if($subService->save()) {
            return redirect('services/show/'.$serviceID)->with('success', 'Sub Service Added Succesfully');
        }
    }

    public function editSubService($id)
    {
        $subService = SubService::find($id);
        return view('services::sub-service.edit', compact('subService'));
    }

    public function updateSubService($id, Request $request) {

        $validator = validator($request->all(), [
            'name' => 'required',
            'desc' => 'required',
            'price' => 'required|numeric|max:10000000|gt:0',
        ]);
        if ($validator->fails()) {
        
            return  Redirect::back()->withInput()->withErrors($validator);
        }
        $serviceID  = $request->service_id;
        $subService = SubService::find($id);
        $subService->service_id = $request->service_id;
        $subService->sub_service_name = $request->name;
        $subService->description = $request->desc;
        $subService->sub_service_price = $request->price;
        if($subService->update())
        {
            return redirect('services/show/'.$serviceID)->with('success', 'Sub Service Updated Succesfully');
        }else{
            return redirect('services/show/'.$serviceID)->with('error', "Sub Service couldn't be Updated");
        }

    }
    
    public function deleteSubService($id)
    {
        $subService = SubService::find($id);
        $serviceId = $subService->service_id;
        if($subService->delete())
        { 
            if(empty(SubService::where('service_id' , $serviceId)->first())){
                $service = Service::find($serviceId);
                $service->state_id = Service::STATE_INACTIVE;
                $service->update();
            }
            return redirect('services/show/'.$subService->service_id)->with('success', 'Sub Service deleted Succesfully');
        }else{
            return redirect('services/show/'.$subService->service_id)->with('error', "Sub Service couldn't be deleted");
        }

    }
    public function deleteAll( Request $request) {
        $serviceID = $request->service_id;
        $subService = DB::table('sub_services')->where('service_id' , $serviceID)->delete();
        if($subService){
            return redirect('services/show/'.$serviceID)->with('success', 'Sub Service deleted Succesfully');
        }

    }
    
} 
