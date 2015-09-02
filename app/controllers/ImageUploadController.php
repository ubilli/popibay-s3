<?php
/**
 *
 * @author Udeme-Samuel <udemesamuel256@gmail.com> <(Popibay Founder/Developer)>
 * @license no-license
 * @copyright Popibay.com © 2015 A Jobinpal Company
 * --------------------------------------------------------
 * 
 */
class ImageUploadController extends \BaseController {

	
	public function image_local(){

	  $all_inputs = Input::all();
	  $files = Input::file('file');

	  $app_token = Input::get('_token');
	  // setting up rules

	  	if (Input::hasFile('file')) {

	  	 foreach ($files as $file) {
	  	  $destinationPath = 'public/pb-uploads/pet_images/'; // upload path
	  	  $thumbnail_path = 'public/pb-uploads/pet_images_thumbnail/';
	  	  $popibay_watermark = 'public/pb-uploads/pet_images/popibay_white_logo_watermark/popibay_watermark_logo.png';
	  	  $popibay_watermark_new = 'public/pb-uploads/pet_images/popibay_white_logo_watermark/popibay_watermark_opacity_logo.png';
	      $extension = $file->getClientOriginalExtension(); // getting image extension
	      $original_name = $file->getClientOriginalName();
	      $random_number = rand(11111,99999);
	      $fileName = $random_number.'.'.$extension; // renaming image

	      // Image::make($file)->resize(600, 357)->insert($popibay_watermark_new,'center')->save($destinationPath.$fileName);

	      Image::make($file)->insert($popibay_watermark_new,'center')->save($destinationPath.$fileName);

	      Image::make($file)->resize(125, 155)->save($thumbnail_path.$fileName); // thumbnail image


	      /**
	      * Add the AWS s3 code to save the image to s3 for speed and cost
	      *
	      */

	      $domain = 'http://popibay.com';
	      $destinationPath = '/pb-uploads/pet_images/'; // upload path
	  	  $thumbnail_path = '/pb-uploads/pet_images_thumbnail/';
	  	  $temp_id = rand(1,100);

	  	  // save temp_id value to session...

	  	  // $temp_saved_id = Petimage::where('temp_id','=',$temp_id)->first();
	      // $temp_saved_id = $temp_saved_id->temp_id;

	      $saved_temp_id = Session::get('saved_temp_id');

	      if ( isset($saved_temp_id) ) {
	      	
	      	$pet_image = new Petimage;
	      	$pet_image->temp_id = $saved_temp_id;
	      	$pet_image->petad_id = 0;
	      	$pet_image->original_name = $original_name;
	      	$pet_image->image_path = $domain.$destinationPath.$fileName;
	      	$pet_image->image_thumbnail_path = $domain.$thumbnail_path.$fileName;
	      	$pet_image->image_name = $fileName;
	      	$pet_image->save();

	      	exit;

	      }

	      // Save to image table...
	      $pet_image = new Petimage;
	      $pet_image->temp_id = $temp_id;
	      $pet_image->petad_id = 0;
	      $pet_image->original_name = $original_name;
	      $pet_image->image_path = $domain.$destinationPath.$fileName;
	      $pet_image->image_thumbnail_path = $domain.$thumbnail_path.$fileName;
	      $pet_image->image_name = $fileName;
	      $pet_image->save();

	      Session::put('saved_temp_id', $temp_id);

	  	 }
	}
}


	public function image_local_to_s3(){
		  $all_inputs = Input::all();
		  $files = Input::file('file');
		  $app_token = Input::get('_token');
		  // setting up rules
		  	if (Input::hasFile('file')) {
		  	 foreach ($files as $file) {
		  	  $destinationPath = 'public/pb-uploads/pet_images/'; // upload path
		  	  $thumbnail_path = 'public/pb-uploads/pet_images_thumbnail/';
		  	  $popibay_watermark = 'public/pb-uploads/pet_images/popibay_white_logo_watermark/popibay_watermark_logo.png';
		  	  $popibay_watermark_new = 'public/pb-uploads/pet_images/popibay_white_logo_watermark/popibay_watermark_opacity_logo.png';
		      $extension = $file->getClientOriginalExtension(); // getting image extension
		      $original_name = $file->getClientOriginalName();
		      $random_number = rand(11111,99999);
		      $fileName = $random_number.'.'.$extension; // renaming image
		      // Image::make($file)->resize(600, 357)->insert($popibay_watermark_new,'center')->save($destinationPath.$fileName);
		      Image::make($file)->insert($popibay_watermark_new,'center')->save($destinationPath.$fileName);
		      Image::make($file)->resize(125, 155)->save($thumbnail_path.$fileName); // thumbnail image

		      $destinationPath_del = $destinationPath;
			  $thumbnail_path_del = $thumbnail_path;

		      $s3_url_domain = 'https://s3.amazonaws.com/';
		      $s3_bucket = 'popibay-bucket-s3/';
		      $s3_destination_path = 'popibay/pb-uploads/pet_images/'.$fileName;
		      $s3_thumbnail_path = 'popibay/pb-uploads/pet_images_thumbnail/'.$fileName;

		      $destination_path_to_s3 = 'pb-uploads/pet_images/';
		      $thumbnail_path_to_s3 = 'pb-uploads/pet_images_thumbnail/';

		      $s3_destination_path_db = $s3_bucket.'popibay/pb-uploads/pet_images/';
		      $s3_thumbnail_path_db = $s3_bucket.'popibay/pb-uploads/pet_images_thumbnail/';


		      $s3 = AWS::get('s3');
		      $s3->putObject(array(
		      	'Bucket'     => 'popibay-bucket-s3',
		      	'Key'        => $s3_destination_path,
		      	'Body' => $destination_path_to_s3.$fileName
		      	));

		      $s3 = AWS::get('s3');
		      $s3->putObject(array(
		      	'Bucket'     => 'popibay-bucket-s3',
		      	'Key'        => $s3_thumbnail_path,
		      	'Body' => $thumbnail_path_to_s3.$fileName
		      	));


		      $domain = $s3_url_domain;
		      $destinationPath = $s3_destination_path_db; // upload path
		  	  $thumbnail_path = $s3_thumbnail_path_db;
		  	  $temp_id = rand(1,100);
		  	  // save temp_id value to session...
		  	  // $temp_saved_id = Petimage::where('temp_id','=',$temp_id)->first();
		      // $temp_saved_id = $temp_saved_id->temp_id;
		      $saved_temp_id = Session::get('saved_temp_id');
		      if ( isset($saved_temp_id) ) {
		      	
		      	$pet_image = new Petimage;
		      	$pet_image->temp_id = $saved_temp_id;
		      	$pet_image->petad_id = 0;
		      	$pet_image->original_name = $original_name;
		      	$pet_image->image_path = $domain.$destinationPath.$fileName;
		      	$pet_image->image_thumbnail_path = $domain.$thumbnail_path.$fileName;
		      	$pet_image->image_name = $fileName;
		      	$pet_image->save();

		      	// delete the file from the two folders to 
			    // prevent the heroku server from crashing due 
			    // to low storage.

			    File::delete($destinationPath_del.$fileName);
			    File::delete($thumbnail_path_del.$fileName);
		      	exit;
		      }
		      // Save to image table...
		      $pet_image = new Petimage;
		      $pet_image->temp_id = $temp_id;
		      $pet_image->petad_id = 0;
		      $pet_image->original_name = $original_name;
		      $pet_image->image_path = $domain.$destinationPath.$fileName;
		      $pet_image->image_thumbnail_path = $domain.$thumbnail_path.$fileName;
		      $pet_image->image_name = $fileName;
		      $pet_image->save();
		      Session::put('saved_temp_id', $temp_id);

		      // delete the file from the two folders to 
		      // prevent the heroku server from crashing due 
		      // to low storage.

		      File::delete($destinationPath_del.$fileName);
		      File::delete($thumbnail_path_del.$fileName);
		  	 }

		}
	}

	public function image(){
		  $all_inputs = Input::all();
		  $files = Input::file('file');
		  $app_token = Input::get('_token');
		  // setting up rules
		  	if (Input::hasFile('file')) {
		  	 foreach ($files as $file) {
		  	  $destinationPath = $_SERVER['DOCUMENT_ROOT'].'/tmp/pb_temp_img/large/';
		  	  $thumbnail_path = $_SERVER['DOCUMENT_ROOT'].'/tmp/pb_temp_img/thumbnail/';
		  	  $popibay_watermark = 'public/pb-uploads/pet_images/popibay_white_logo_watermark/popibay_watermark_logo.png';
		  	  $popibay_watermark_new = 'public/pb-uploads/pet_images/popibay_white_logo_watermark/popibay_watermark_opacity_logo.png';
		      $extension = $file->getClientOriginalExtension(); // getting image extension
		      $original_name = $file->getClientOriginalName();
		      $random_number = rand(11111,99999);
		      $fileName = $random_number.'.'.$extension; // renaming image
		      // Image::make($file)->resize(600, 357)->insert($popibay_watermark_new,'center')->save($destinationPath.$fileName);
		      Image::make($file)->insert($popibay_watermark_new,'center')->save($destinationPath.$fileName);
		      Image::make($file)->resize(125, 155)->save($thumbnail_path.$fileName); // thumbnail image

		      $destinationPath_del = $destinationPath;
			  $thumbnail_path_del = $thumbnail_path;

		      $s3_url_domain = 'https://s3.amazonaws.com/';
		      $s3_bucket = 'popibay-bucket-s3/';
		      $s3_destination_path = 'popibay/pb-uploads/pet_images/'.$fileName;
		      $s3_thumbnail_path = 'popibay/pb-uploads/pet_images_thumbnail/'.$fileName;

		      $destination_path_to_s3 = 'pb-uploads/pet_images/';
		      $thumbnail_path_to_s3 = 'pb-uploads/pet_images_thumbnail/';

		      $s3_destination_path_db = $s3_bucket.'popibay/pb-uploads/pet_images/';
		      $s3_thumbnail_path_db = $s3_bucket.'popibay/pb-uploads/pet_images_thumbnail/';


		      $s3 = AWS::get('s3');
		      $s3->putObject(array(
		      	'Bucket'     => 'popibay-bucket-s3',
		      	'Key'        => $s3_destination_path,
		      	'Body' => $destination_path_to_s3.$fileName
		      	));

		      $s3 = AWS::get('s3');
		      $s3->putObject(array(
		      	'Bucket'     => 'popibay-bucket-s3',
		      	'Key'        => $s3_thumbnail_path,
		      	'Body' => $thumbnail_path_to_s3.$fileName
		      	));


		      $domain = $s3_url_domain;
		      $destinationPath = $s3_destination_path_db; // upload path
		  	  $thumbnail_path = $s3_thumbnail_path_db;
		  	  $temp_id = rand(1,100);
		  	  // save temp_id value to session...
		  	  // $temp_saved_id = Petimage::where('temp_id','=',$temp_id)->first();
		      // $temp_saved_id = $temp_saved_id->temp_id;
		      $saved_temp_id = Session::get('saved_temp_id');
		      if ( isset($saved_temp_id) ) {
		      	
		      	$pet_image = new Petimage;
		      	$pet_image->temp_id = $saved_temp_id;
		      	$pet_image->petad_id = 0;
		      	$pet_image->original_name = $original_name;
		      	$pet_image->image_path = $domain.$destinationPath.$fileName;
		      	$pet_image->image_thumbnail_path = $domain.$thumbnail_path.$fileName;
		      	$pet_image->image_name = $fileName;
		      	$pet_image->save();

		      	// delete the file from the two folders to 
			    // prevent the heroku server from crashing due 
			    // to low storage.

			    File::delete($destinationPath_del.$fileName);
			    File::delete($thumbnail_path_del.$fileName);
		      	exit;
		      }
		      // Save to image table...
		      $pet_image = new Petimage;
		      $pet_image->temp_id = $temp_id;
		      $pet_image->petad_id = 0;
		      $pet_image->original_name = $original_name;
		      $pet_image->image_path = $domain.$destinationPath.$fileName;
		      $pet_image->image_thumbnail_path = $domain.$thumbnail_path.$fileName;
		      $pet_image->image_name = $fileName;
		      $pet_image->save();
		      Session::put('saved_temp_id', $temp_id);

		      // delete the file from the two folders to 
		      // prevent the heroku server from crashing due 
		      // to low storage.

		      File::delete($destinationPath_del.$fileName);
		      File::delete($thumbnail_path_del.$fileName);
		  	 }

		}
	}
	

	public function edit_local(){

	  $petad_id = Input::get('petad-id');
	  $all_inputs = Input::all();
	  $files = Input::file('file');

	  // setting up rules

	  	if (Input::hasFile('file')) {

	  	 foreach ($files as $file) {
	  	  $destinationPath = 'public/pb-uploads/pet_images/'; // upload path
	  	  $thumbnail_path = 'public/pb-uploads/pet_images_thumbnail/';
	  	  $popibay_watermark = 'public/pb-uploads/pet_images/popibay_white_logo_watermark/popibay_watermark_logo.png';
	  	  $popibay_watermark_new = 'public/pb-uploads/pet_images/popibay_white_logo_watermark/popibay_watermark_opacity_logo.png';
	      $extension = $file->getClientOriginalExtension(); // getting image extension
	      $original_name = $file->getClientOriginalName();
	      $random_number = rand(11111,99999);
	      $fileName = $random_number.'.'.$extension; // renaming image

	      // Image::make($file)->resize(600, 357)->insert($popibay_watermark_new,'center')->save($destinationPath.$fileName);

	      Image::make($file)->insert($popibay_watermark_new,'center')->save($destinationPath.$fileName);

	      Image::make($file)->resize(125, 155)->save($thumbnail_path.$fileName); // thumbnail image

	      $domain = 'http://popibay.com';
	      $destinationPath = '/pb-uploads/pet_images/'; // upload path
	  	  $thumbnail_path = '/pb-uploads/pet_images_thumbnail/';
	  	  $temp_id = rand(1,100);

	  	  	// save temp_id value to session...

	  	  $temp_saved_id = Petimage::where('petad_id','=',$petad_id)->first();
	  	  $temp_saved_id = $temp_saved_id->temp_id;

	  	  $saved_temp_id = $temp_saved_id;

	      	// if ( isset($saved_temp_id) ) {

	  	  $pet_image = new Petimage;
	  	  $pet_image->temp_id = $saved_temp_id;
	  	  $pet_image->petad_id = $petad_id;
	  	  $pet_image->original_name = $original_name;
	  	  $pet_image->image_path = $domain.$destinationPath.$fileName;
	  	  $pet_image->image_thumbnail_path = $domain.$thumbnail_path.$fileName;
	  	  $pet_image->image_name = $fileName;
	  	  $pet_image->save();

	  	  Session::put('saved_temp_id', $saved_temp_id);
		}
	}
}

	public function edit(){

	  // edit s3 file...
	  $petad_id = Input::get('petad-id');
	  $all_inputs = Input::all();
	  $files = Input::file('file');

	  // setting up rules

	  	if (Input::hasFile('file')) {

	  	 foreach ($files as $file) {
	  	  $destinationPath = 'public/pb-uploads/pet_images/'; // upload path
	  	  $thumbnail_path = 'public/pb-uploads/pet_images_thumbnail/';
	  	  $popibay_watermark = 'public/pb-uploads/pet_images/popibay_white_logo_watermark/popibay_watermark_logo.png';
	  	  $popibay_watermark_new = 'public/pb-uploads/pet_images/popibay_white_logo_watermark/popibay_watermark_opacity_logo.png';
	      $extension = $file->getClientOriginalExtension(); // getting image extension
	      $original_name = $file->getClientOriginalName();
	      $random_number = rand(11111,99999);
	      $fileName = $random_number.'.'.$extension; // renaming image

	      // Image::make($file)->resize(600, 357)->insert($popibay_watermark_new,'center')->save($destinationPath.$fileName);

	      Image::make($file)->insert($popibay_watermark_new,'center')->save($destinationPath.$fileName);

	      Image::make($file)->resize(125, 155)->save($thumbnail_path.$fileName); // thumbnail image

	      $destinationPath_del = $destinationPath;
	      $thumbnail_path_del = $thumbnail_path;

	      $s3_url_domain = 'https://s3.amazonaws.com/';
	      $s3_bucket = 'popibay-bucket-s3/';
	      $s3_destination_path = 'popibay/pb-uploads/pet_images/'.$fileName;
	      $s3_thumbnail_path = 'popibay/pb-uploads/pet_images_thumbnail/'.$fileName;

	      $destination_path_to_s3 = 'pb-uploads/pet_images/';
	      $thumbnail_path_to_s3 = 'pb-uploads/pet_images_thumbnail/';

	      $s3_destination_path_db = $s3_bucket.'popibay/pb-uploads/pet_images/';
	      $s3_thumbnail_path_db = $s3_bucket.'popibay/pb-uploads/pet_images_thumbnail/';


	      $s3 = AWS::get('s3');
	      $s3->putObject(array(
	      	'Bucket'     => 'popibay-bucket-s3',
	      	'Key'        => $s3_destination_path,
	      	'Body' => $destination_path_to_s3.$fileName
	      	));

	      $s3 = AWS::get('s3');
	      $s3->putObject(array(
	      	'Bucket'     => 'popibay-bucket-s3',
	      	'Key'        => $s3_thumbnail_path,
	      	'Body' => $thumbnail_path_to_s3.$fileName
	      	));


	      $domain = $s3_url_domain;
		  $destinationPath = $s3_destination_path_db; // upload path
		  $thumbnail_path = $s3_thumbnail_path_db;
	      // $domain = 'http://popibay.com';
	      // $destinationPath = '/pb-uploads/pet_images/'; // upload path
	  	  // $thumbnail_path = '/pb-uploads/pet_images_thumbnail/';
	  	  $temp_id = rand(1,100);

	  	  	// save temp_id value to session...

	  	  $temp_saved_id = Petimage::where('petad_id','=',$petad_id)->first();
	  	  $temp_saved_id = $temp_saved_id->temp_id;

	  	  $saved_temp_id = $temp_saved_id;

	      	// if ( isset($saved_temp_id) ) {

	  	  $pet_image = new Petimage;
	  	  $pet_image->temp_id = $saved_temp_id;
	  	  $pet_image->petad_id = $petad_id;
	  	  $pet_image->original_name = $original_name;
	  	  $pet_image->image_path = $domain.$destinationPath.$fileName;
	  	  $pet_image->image_thumbnail_path = $domain.$thumbnail_path.$fileName;
	  	  $pet_image->image_name = $fileName;
	  	  $pet_image->save();

	  	  Session::put('saved_temp_id', $saved_temp_id);

	  	  File::delete($destinationPath_del.$fileName);
		  File::delete($thumbnail_path_del.$fileName);
		}
	}
}



	// not working just a back up
	public function deleteimages(){
		$removed_image = Input::get('removed_image'); //former name
		$added_images = Session::all();
		$added_image = Session::get($removed_image);
		$new_file_name = $added_image['newfilename'];


		$destinationPath = 'public/pb-uploads/pet_images/';

		/*
			TODO FOR THE IMAGE FILE
			-----------------------
			* Delete it from the /pet-image path
			* Delete it from the session
		*/



		// delete from the folder

		File::delete($destinationPath.$new_file_name);

		// Deleted the image from the session.

		Session::forget($removed_image);

	}

	// working 
	public function deleteimagess(){
		$removed_image = Input::get('removed_image'); //former name
		$destinationPath = 'public/pb-uploads/pet_images/';

		// check the file where it is in the database for the new name
		// using the former name as an id...

		$tempimageupload = Tempimageupload::where('original_image_name', '=', $removed_image)->first();

		$new_file_name = $tempimageupload->new_file_name;
		/*
			TODO FOR THE IMAGE FILE
			-----------------------
			* Delete it from the /pet-image path
			* Delete it from the database
		*/



		// delete from the folder

		File::delete($destinationPath.$new_file_name);

		// delete from the database

		Tempimageupload::where('original_image_name', '=', $removed_image)->delete();

	}

	public function deleteimagessr(){
		$removed_image = Input::get('removed_image'); //former name
		$destinationPath = 'public/pb-uploads/pet_images/'; // upload path
	  	$thumbnail_path = 'public/pb-uploads/pet_images_thumbnail/';
		$saved_temp_id = Session::get('saved_temp_id');

		$saved_img = Petimage::where('original_name', '=', $removed_image)->first();
		$image_name = $saved_img->image_name;

		File::delete($destinationPath.$image_name);
		File::delete($thumbnail_path.$image_name);

		$saved_img->delete();

	}

	public function deleteimage(){
		
		/* S3 delete */
		// this function deletes preview file on s3.
		$removed_image = Input::get('removed_image'); //former name
		$destinationPath = 'public/pb-uploads/pet_images/'; // upload path
	  	$thumbnail_path = 'public/pb-uploads/pet_images_thumbnail/';
		$saved_temp_id = Session::get('saved_temp_id');

		$saved_img = Petimage::where('original_name', '=', $removed_image)->first();
		$image_name = $saved_img->image_name;

		//File::delete($destinationPath.$image_name);
		//File::delete($thumbnail_path.$image_name);

		// $saved_img->delete();



		// $s3_url_domain = 'https://s3.amazonaws.com/';
		//$s3_bucket = 'popibay-bucket-s3/';
		$s3_destination_path = 'popibay/pb-uploads/pet_images/'.$image_name;
		$s3_thumbnail_path = 'popibay/pb-uploads/pet_images_thumbnail/'.$image_name;

		//$destination_path_to_s3 = 'pb-uploads/pet_images/';
		//$thumbnail_path_to_s3 = 'pb-uploads/pet_images_thumbnail/';

		//$s3_destination_path_db = $s3_bucket.'popibay/pb-uploads/pet_images/';
		//$s3_thumbnail_path_db = $s3_bucket.'popibay/pb-uploads/pet_images_thumbnail/';


		$s3 = AWS::get('s3');
		$s3->deleteObject(array(
			'Bucket'     => 'popibay-bucket-s3',
			'Key'        => $s3_destination_path
			));

		$s3 = AWS::get('s3');
		$s3->deleteObject(array(
			'Bucket'     => 'popibay-bucket-s3',
			'Key'        => $s3_thumbnail_path
			));

		$saved_img->delete();

	}


}
