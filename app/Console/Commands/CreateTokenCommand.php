<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateTokenCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:token {email? : The email of the user} {--name=API : The token name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Sanctum API token for a user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        if (!$email) {
            $email = $this->ask('Enter the email of the user');
        }
        
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("User with email {$email} not found!");
            return 1;
        }
        
        $tokenName = $this->option('name');
        
        // Revoke old tokens with the same name
        $user->tokens()->where('name', $tokenName)->delete();
        
        // Create new token
        $token = $user->createToken($tokenName)->plainTextToken;
        
        $this->info("Token created successfully:");
        $this->info($token);
        
        $this->info("\nTest the token with:");
        $this->info("curl -H 'Authorization: Bearer {$token}' http://localhost:8000/api/test");
        
        return 0;
    }
}
