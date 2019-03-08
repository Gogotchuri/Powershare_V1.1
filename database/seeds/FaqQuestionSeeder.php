<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class FaqQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questions = [
            [
                'question' => 'What is POWERSHARE?',
                'answer' => 'Powershare is a charity crowdfunding platform with diverse campaign categories and donation options, which include Fiat, cryptocurrency and CPU donations.',
                'frequency' => 119

            ],

            [
                'question' => 'How is Powershare different from other Crowdfunding platforms?',
                'answer' => "Powershare is the first company that uses browser-based cryptocurrency mining to fire up important ideas and causes so that anybody with access to internet can become a supporting hero without spending a penny from their pockets. Backers can either choose this innovative donation option, or simply support a chosen cause via integrated PayPal and/or MetaMask applications.",
                'frequency' => 118
            ],

            [
                'question' => 'What is Crowdfunding?',

                'answer' => 'Crowdfunding is the practice of funding a project by raising money from a large number of people who each contribute a relatively small amount.',

                'frequency' => 117
            ],

            [
                'question' => 'How do I donate my computing power?',

                'answer' => 'Select a campaign you think is important, go to their page, and click ‘start mining’.',

                'frequency' => 116
            ],


            [
                'question' => 'How will CPU donations affect my computer?',

                    'answer' => 'Your CPU percentage, shown in ‘task manager’ will rise according to how much speed you are donating. It will slightly increase energy consumption of your computer, and it may slow down if total consumption will exceed 50%. Recommended CPU donations are 20-30% but may vary for different hardware.',

                    'frequency' => 115
            ],

            [
                'question' => 'How much will my computer earn?',

                'answer' => 'With Coinhive technology, it will be substantially low, couple of cents after 24 hours of mining.',

                'frequency' => 114
            ],

            [
                'question' => 'If my computer earns so little, what is the point of the feature?',

                'answer' => 'By mining at least a few hours for a chosen cause, you greatly support the testing and development of our platform, as this is the alpha version of Powershare the next versions of the platform will improve the existing technology. ',

                'frequency' => 113
            ],

            [
                'question' => 'When will cashless donation feature generate reasonable amounts of cash?',

                'answer' => 'After thorough testing, the next versions of the platform will improve the technology. Donated CPU will be utilized by scientific research institutions that will in return generate digital currency – FIRE. The aim is to increase the profitability of a desktop computer to up to 10 cents per hour.',

                'frequency' => 112
            ],

            [
                'question' => 'How much CPU power should I donate?',

                'answer' => 'We recommend donating 20-30% of your CPU power.',

                'frequency' => 111
            ],

            [
                'question' => 'Is my computer safe while mining?',

                'answer' => 'Fundmining is a process of browser-based mining for fundraising purposes only.Yes, it’s completely safe. The scripts are secure; however some ad blockers and other widgets might block the feature. Future development of the feature aims to improve on this constraint as well. Keep in mind - Mining with smart phones might drain your battery power. Also avoid donating more than 50% of your processing power in order to smoothly operate your hardware.',

                'frequency' => 110
            ],

            [
                'question' => 'How can I donate apart from fundmining?',

                'answer' => 'Direct donations via PayPal are available, as well as Ethereum donations from your digital wallet.',

                'frequency' => 109
            ],

            [
               'question' => 'What is cryptocurrency mining?',

                'answer' => 'Cryptocurrency mining is a process of verifying transactions and adding them into blockchain digital ledger which creates new coins.',

                'frequency' => 108
            ],

            [
                'question' => 'What is CPU power?',

                'answer' => 'CPU is the abbreviation for central processing unit. It is most commonly called a processor, and is the brains of the computer where most calculations take place.',

                'frequency' => 107
            ],

            [
                'question' => 'What is blockchain?',

                'answer' => 'Blockchain is a distributed digital ledger in which all the transactions are recorded chronologically and publicly for everyone to see.',

                'frequency' => 106
            ],

            [
                'question' => 'What is Coinhive?',

                'answer' => 'Coinhive is a set of scrypts that transfer user’s computing power to mining pools, which then mine for cryptocurrency.',

                'frequency' => 105
            ],

            [
                'question' => 'Which currency is mined on POWERSHARE?',

                'answer' => 'Currently, Monero.',

                'frequency' => 104
            ],

            [
                'question' => 'How do I create a cryptocurrency wallet?',

                'answer' => 'We suggest installing Metamask extension which will generate wallets itself. Additionally, Metamask is also integrated into the POWERSHARE platform for more simplicity.',

                'frequency' => 103
            ],

            [
                'question' => 'What is MetaMask?',

                'answer' => 'MetaMask is a cryptocurrency wallet for ERC20 tokens.',

                'frequency' => 102
            ],

            [
                'question' => 'How long does the account approval process take?',

                'answer' => 'Mostly it’s instant, but it can take up to 72 hours.',

                'frequency' => 101
            ],

            [
                'question' => 'How do I start a campaign?',

                'answer' => 'Register into your account and go to your profile page. After clicking ‘create a campaign’, you will get a registration form. For further assistance please contact our support.',

                'frequency' => 100
            ],

        ];

        foreach ($questions as $question) {
            $newQuestion = new \App\Models\FaqQuestion();

            $newQuestion->question = $question['question'];
            $newQuestion->answer = $question['answer'];         
            $newQuestion->frequency = (array_key_exists('frequency', $question)) ? $question['frequency'] : 1;

            $newQuestion->save();
        }
    }
}
