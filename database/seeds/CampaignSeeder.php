<?php

use Illuminate\Database\Seeder;
use App\Models\Campaign;
class CampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $campaigns = [
            [
                'id' => 1,
                'name' => 'Help Clean the Hill',
                'category_id' => 1,
                'details' => 'A small village in South Georgia didn\'t have recycled bins for years, therefore the villagers would gather the garbage and throw it away at the end of the village. This took place for years and the results are as shown in the picture. Most of the garbage already rotted, but a lot of it still remains. Thankfully, now the villagers have put out recycled bins and they no longer have to keep on throwing the garbage out like this, but the place still needs to be cleaned.',
                'required_funding' => 53000,
                'realized_funding' => 38000,
                'author_id' => 1,
                'status_id' => 1,
                'video_url' => null,
                'ethereum_address' => 'LeXUY41u9LXMkox38EHrW5aAAcC8qbodQw'
            ],

            [
                'id' => 2,
                'name' => 'Help Study Arab Language',
                'category_id' => 1,
                'details' => "I am 4th year student at the Free University of Tbilisi, Georgia(Country). I always wanted to speak Arabic, that's why I chose the faculty of International Relations with Arabic Language concentration. But learning language at the University isn't enough, not to mention Arabic language, which is considered to be one of the most difficult-to-learn languages. I thought maybe one day I will be able to study and practice this language in country I always liked and wanted to visit - Lebanon. I was surfing on the web to find some courses suitable to my budget, the only thing I realized was that Lebanon is 5x(times) expensive, than Georgia.",
                'required_funding' => 30000,
                'realized_funding' => 10000,
                'author_id' => 1,
                'status_id' => 1,
                'video_url' => null,
                'ethereum_address' => 'LeXUY41u9LXMkox38EHrW5aAAcC8qbodQw'
            ],

            [
                'id' => 3,
                'name' => 'CryptoZ',
                'category_id' => 2,
                'details' => 'It all started over a phone call, from Tbilisi to London. Two old friends and blockchain enthusiasts Beka and David were talking over the phone and complaining about the lack of knowledge of the blockchain technology in the society and how the lack of information and educational materials could lead to disastrous financial losses among common folks. The temptation to invest in cryptocurrencies was great, however both of them realized how damaging could such an investment be, without the proper understanding of the industry and technology behind it.',
                'required_funding' => 200000,
                'realized_funding' => 150000,
                'author_id' => 1,
                'status_id' => 1,
                'video_url' => null,
                'ethereum_address' => 'LeXUY41u9LXMkox38EHrW5aAAcC8qbodQw'
            ],
        ];

        foreach ($campaigns as $campaign) {
            $n_camp = new Campaign();

            $n_camp->id = $campaign['id'];
            $n_camp->name = $campaign['name'];
            $n_camp->category_id = $campaign['category_id'];
            $n_camp->details = $campaign['details'];
            $n_camp->required_funding = $campaign['required_funding'];
            $n_camp->realized_funding = $campaign['realized_funding'];
            $n_camp->author_id = $campaign['author_id'];
            $n_camp->status_id = $campaign['status_id'];
            $n_camp->video_url = $campaign['video_url'];
            $n_camp->ethereum_address = $campaign['ethereum_address'];

            $n_camp->save();
        }
    }
}
