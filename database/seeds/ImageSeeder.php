<?php
use Illuminate\Database\Seeder;
use App\Models\References\ImageCategory;
use App\Models\Image;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $image = new Image();
        $image->name = "Featured Image";
        $image->category_id = ImageCategory::FEATURED;
        $image->campaign_id = 1;
        $image->url = 'https://cz-public-images-test.s3.amazonaws.com/powershare-5YtTOa2JOVkjdl4GvVqOpx23YMsKug1kjg6Y9j50.png';
        $image->thumbnail_url = 'https://cz-public-images-test.s3.amazonaws.com/powershare-thumbnail-5YtTOa2JOVkjdl4GvVqOpx23YMsKug1kjg6Y9j50.png';
        $image->save();

        $image = new Image();
        $image->name = "Gallery Image";
        $image->category_id = ImageCategory::GALLERY;
        $image->campaign_id = 2;
        $image->url = 'https://cz-public-images-test.s3.amazonaws.com/powershare-5YtTOa2JOVkjdl4GvVqOpx23YMsKug1kjg6Y9j50.png';
        $image->thumbnail_url = 'https://cz-public-images-test.s3.amazonaws.com/powershare-thumbnail-5YtTOa2JOVkjdl4GvVqOpx23YMsKug1kjg6Y9j50.png';
        $image->save();

        factory("App\Models\Image", 30)->create();
    }
}
