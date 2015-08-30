
<?php

class Product extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	// protected $table = 'products';

	// relation
	public function images(){
		return $this->belongsToMany('Image','product_images');
	}
	

}
