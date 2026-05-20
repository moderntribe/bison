<?php

namespace App\Console\Commands;

use App\Mail\TestEmail;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class TestMailDriver extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-mail-driver {recipientEmail : The email address to send the test mail to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test mail to the specified email address';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        if (App::environment('production')) {
            $this->error('This command is not allowed in production');

            return;
        }

        // validate the email address
        $validator = Validator::make($this->arguments(), [
            'recipientEmail' => 'required|email',
        ]);

        if ($validator->fails()) {
            $this->error($validator->errors()->first());

            return;
        }

        Mail::to($validator->safe()->input('recipientEmail'))->send(new TestEmail);

        $this->info('Test email sent');
    }

    /**
     * @return array<string, string>
     */
    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'recipientEmail' => 'Enter the email address to send the test mail to',
        ];
    }
}
