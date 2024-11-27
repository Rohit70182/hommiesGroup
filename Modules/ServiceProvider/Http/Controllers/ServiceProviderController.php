<?php
namespace Modules\ServiceProvider\Http\Controllers;

use App\Models\Notification;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Modules\ServiceProvider\Entities\ServiceProvider;
use Modules\ServiceProvider\Entities\BookServiceProvider;
use Modules\Services\Entities\Service;
use App\Models\ProviderServices;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ServiceProviderController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index()
    {
        $provider = ServiceProvider::orderBy('id', 'DESC')->paginate(10);
        return view('serviceprovider::index', compact('provider'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Renderable
     */
    public function create()
    {
        $services = Service::orderBy('id','DESC')->get();
        return view('serviceprovider::create',compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), 
            [
            'name' => 'required|string|max:30',
            'gender' => 'required',
            'dob' => 'before:today', // Doesn't accept today date
            'address' => 'required',
            'phone' => 'required|regex:/[0-9]/|not_regex:/[a-z]/|min:10|max:15',        
            'experience' => 'required|integer|gt:0',
            'image' => 'required|mimes:jpeg,png,jpg|max:2048',
            'certifications' => 'required|mimes:jpeg,png,jpg|max:2048',
            'services' => 'required',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time'
        ], 
            [
            'end_time.date_format' => 'End time must be time',
            'end_time.after' => 'End time must be greater than start time'
        ]
        );

        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }
        
        
        $provider = new ServiceProvider();
        $provider->name = $request->input('name');
        $provider->date_of_birth = $request->input('dob');
        $provider->gender = $request->input('gender');
        $provider->email =  $request->input('email');  // send password on mail using smtp

        // time to gmt
        $time_s = $request->input('start_time');
        $time_e = $request->input('end_time');
        $provider->start_time = gmdate($time_s);
        $provider->end_time = gmdate($time_e);
        $provider->state_id= ServiceProvider::STATE_ACTIVE;
        $provider->address = $request->input('address');
        $provider->contact = $request->input('phone');
        $provider->experience = $request->input('experience');
        // $provider->services()->sync($request->services);

        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extenstion;
            $file->move('public/uploads', $filename);
            $provider->image = $filename;
        }

        if ($request->hasfile('certifications')) {
            $file = $request->file('certifications');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extenstion;
            $file->move('public/uploads', $filename);
            $provider->certifications = $filename;
        }

        $sk=env('STRIPE_SECRET');
        $stripe = new \Stripe\StripeClient('sk_test_u8wpq1V94OaLmPyYGJiMj1HO');
        $data = $stripe->customers->create([
            'description' => 'My First Test Customer (created for API docs at https://www.stripe.com/docs/api)',
        ]);
        // $provider->customer_id= $data->id;
        if ($provider->save()) {
            Notification::create([                 // on temporary base remove when password sent on email
                'title' => "provider's , ". $provider->name,
                'description' => "provider's",
                'model_type' => 'User',
                'to_user_id' => User::ROLE_ADMIN,
                'created_by_id' => $provider->id
            ]);
            $services = $request->services;
            $providerId = $provider->id;
            foreach($services as $service) {
                $providerService = new ProviderServices();
                $providerService->service_provider_id = $providerId;
                $providerService->service_id = $service;
                $providerService->save();
            }

            return redirect('/serviceProvider')->with('success', "Service Provider created Successfully");
        } else {
            return redirect()->back()->with('error', "Error Occurred,Service Provider Couldn't be Updated.");
        }
    }

    /**
     * Show the specified resource.
     *
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $provider = User::where('id', $id)->with('comments')->first();
      
        
        $services = ProviderServices::where('service_provider_id',$id)->get();
        
        $serviceNames = [];
        
        foreach($services as $service) {
            $serviceName = Service::where('id',$service->service_id)->pluck('name')->first();
            $serviceNames[] = $serviceName; 
        }
        
        if($provider){
            return view('serviceprovider::show', compact('provider','serviceNames'));            
        } else {
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $provider = User::find($id);
        
        $services = Service::orderBy('id','DESC')->get();

        return view('serviceprovider::edit', compact('provider','services'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $validator = validator($request->all(), 
            [
                'name' => 'required|string|max:30',
                'gender' => 'required',
                'dob' => 'before:today', // Doesn't accept today date
                'address' => 'required',
                'phone' => 'required|regex:/[0-9]/|not_regex:/[a-z]/|min:10|max:15', 
                'experience' => 'required|integer|gt:0',
                'image' => 'mimes:jpeg,png,jpg|max:2048',
                'certifications' => 'mimes:jpeg,png,jpg|max:2048',
                'services' => 'required',
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i|after:start_time'
                
            ],
            [
                'end_time.date_format' => 'End time must be time',
                'end_time.after' => 'End time must be greater than start time'
            ]
            );

        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }
        
        $provider = User::find($id);
        $provider->name = $request->input('name');
        $provider->dob = $request->input('dob');
        $provider->gender = $request->input('gender');

        // time to gmt
        $time_s = $request->input('start_time');
        $time_e = $request->input('end_time');

        $provider->start_time = gmdate($time_s);
        $provider->end_time = gmdate($time_e);

        $provider->phone = $request->input('phone');
        $provider->address = $request->input('address');
        $provider->latitude = $request->input('latitude');
        $provider->longitude = $request->input('longitude');
        $provider->experience = $request->input('experience');

        if ($request->hasfile('certifications')) {
            $file = $request->file('certifications');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extenstion;
            $file->move('public/uploads', $filename);
            $provider->certifications = $filename;
        }

        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extenstion;
            $file->move('public/uploads', $filename);
            $provider->image = $filename;
        }

        if ($provider->update()) {
            
            $services = $request->services;
            $providerId = $provider->id;
            $checkServices = ProviderServices::where('service_provider_id',$providerId)->get();
            if(count($checkServices)>0) {
                
                $deleteServices = ProviderServices::where('service_provider_id',$providerId)->delete();
                if($deleteServices) {
                    foreach($services as $service) {
                        $providerService = new ProviderServices();
                        $providerService->service_provider_id = $providerId;
                        $providerService->service_id = $service;
                        $providerService->save();
                    }
                }
            } else {
                
                foreach($services as $service) {
                    $providerService = new ProviderServices();
                    $providerService->service_provider_id = $providerId;
                    $providerService->service_id = $service;
                    $providerService->save();
                }
            }
            
            return redirect('/serviceProvider')->with('success', "Service Provider has been Updated Successfully");
        } else {
            return redirect()->back()->with('error', "Error Occurred,Service Provider Couldn't be Updated.");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $provider = User::where('id', $id)->first();
        $bookProvider = BookServiceProvider::where('service_provider_id', $id)->first();
        if(!empty($bookProvider))
        {
            return redirect()->back()->with('error', "Service Provider can't be deleted as it has been booked");
        } else {
            if($provider->delete()){
                $getServices = ProviderServices::where('service_provider_id',$id)->delete();
            }
            
            return redirect('/serviceProvider')->with('success', 'Service Provider deleted succesfully');
        }
        
    }
    
    public function softDelete($id)
    {
        
        try
        {
            $user = User::where('id', $id)->first();
            
            if($user->state_id == User::STATE_INACTIVE)
            {
                $user->state_id = User::STATE_ACTIVE;
                $user->save();
                return redirect()->back();
                //                 return redirect()->back()->with('error', "Account not found");
            }
            else
            {
                $user->state_id = ServiceProvider::STATE_INACTIVE;
                $user->save();
                return redirect()->back();
                //                 return redirect()->back()->with('error', "Account not found");
            }
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with($e->getMessage());
        }
    }
    

    public function favourite($id)
    {
        $provider = ServiceProvider::where('id', $id)->first();
        if ($provider->state_id == ServiceProvider::STATE_FAVOURITE) {
            $provider->state_id = ServiceProvider::STATE_NOT_FAVOURITE;
        } else {
            $provider->state_id = ServiceProvider::STATE_FAVOURITE;
        }
    }
}
