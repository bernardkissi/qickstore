 // // Property::distinct()->select('property_name')->groupBy('property_name')->get();

        // $collect = DB::table('filters')
        //     ->select('property_name', 'property_value')
        //     ->distinct()
        //     ->get();

        //   $arr = collect($collect)->groupBy('property_name');

        // foreach ($arr as $key => $value) {
        //     echo $key;
        // }

        // return collect(PropertyResource::collection(Property::all())->distinct()->groupBy('property_name'));