public function update(Request $request, $id){
    	$validator=Validator::make($request->all(),[
    		'title' => 'required',
    		'body' => 'required',
    		'image' => 'image|nullable|max:2000',
    	]);
    	if($validator->fails()){
    		return redirect()->back()->withErrors($validator)->withInput();
    	}

    	if($request->hasFile('image')){
    		$fileNameWithExt = $request->file('image')->getClientOriginalName();
    		$fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
    		$extension = $request->file('image')->getClientOriginalExtension();
    		$fileNameDatabase = $fileName.'_'.time().'.'.$extension;
    		$path = $request->file('image')->storeAs('public\images',$fileNameDatabase);
    	}

    	$posts = posts::find($id);
    	if($request->hasFile('image')){
    		$posts->image = $fileNameDatabase;    		
    	}
    	$posts->title = $request->title;
    	$posts->body = $request->body;
    	$posts->save();

    	return redirect()->route('posts')->with('postupdated','The post has been updated.');
    }
