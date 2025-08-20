<?php

namespace App\Tools;

use App\Models\User;
use Vizra\VizraADK\Contracts\ToolInterface;
use Vizra\VizraADK\Memory\AgentMemory;
use Vizra\VizraADK\System\AgentContext;

class UserLookupTool implements ToolInterface
{
    /**
     * Get the tool's definition for the LLM.
     * This structure should be JSON schema compatible.
     */
    public function definition(): array
    {
        return [
            'name' => 'user_lookup',
            'description' => 'Lookup user information by user_email or user_name.',
            'parameters' => [
                'type' => 'object',
                'properties' => [
                    'user_email' => [
                        'type' => 'string',
                        'description' => 'The email address of the user to look up.'
                    ],
                    'user_name' => [
                        'type' => 'string',
                        'description' => 'The name of the user to look up.'
                    ]
                ],
            ],
        ];
    }

    /**
     * Execute the tool's logic.
     *
     * @param array $arguments Arguments provided by the LLM, matching the parameters defined above.
     * @param AgentContext $context The current agent context, providing access to session state etc.
     * @return string JSON string representation of the tool's result.
     */
    public function execute(array $arguments, AgentContext $context, AgentMemory $memory): string
    {
        // Access arguments: $location = $arguments['location'] ?? null;
        // Access context: $sessionId = $context->getSessionId();
        // Access state: $previousValue = $context->getState('some_key');

        $user = User::where('email', $arguments['user_email'] ?? null)
            ->orWhere('name', $arguments['user_name'] ?? null)
            ->first();

        if (!$user) {
            return json_encode([
                'status' => 'error',
                'message' => 'User not found.',
                'user_email' => $arguments
            ]);
        }

        $memory->addFact("User looked up: {$user->email}");
        $memory->addLearning("User email looked up: {$user->email}");

        // Implement tool logic here...
        $result = [
            'status' => 'success',
            'message' => 'Tool user_lookup executed with arguments: ' . json_encode($arguments),
            // Add relevant data to the result
            'data' => [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
            ]
        ];

        // The result MUST be a JSON encoded string.
        return json_encode($result);
    }
}
