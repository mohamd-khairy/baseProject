<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Arr;

class NotificationService
{
    /**
     * @param string|array $types
     */
    public function __construct(public string|array $types = 'notify')
    {
    }

    /**
     * @param User $user
     * @param array $data
     * @return void
     */
    final public function handle(User $user, array $data): void
    {
        $typeHandlers = [
            'notify' => fn() => $this->sendNotify($user, $data),
            'sms' => fn() => $this->sendSMS($data),
            'email' => fn() => $this->sendEmail($user, $data),
            'realtime' => fn() => $this->sendRealtimeNotification($user, $data),
        ];

        foreach ($this->types as $type) {
            if (!isset($typeHandlers[$type])) {
                continue;
            }

            try {
                $typeHandlers[$type]();
            } catch (\Throwable $exception) {
                info("Error => " . $exception->getMessage());
                continue;
            }
        }
    }


    /**
     * @param User $user
     * @param array $data
     * @return bool
     */
    private static function sendNotify(User $user, array $data): bool
    {
        //

        return true;
    }

    /**
     * @param array $data
     * @return bool
     */
    private static function sendSMS(array $data): bool
    {
        return true;
    }

    /**
     * @param User $user
     * @param array $data
     * @return bool
     */
    private static function sendEmail(User $user, array $data): bool
    {
        //

        return true;
    }

    /**
     * @param User $user
     * @param array $data
     * @return bool
     */
    private static function sendRealtimeNotification(User $user, array $data): bool
    {
        //

        return true;
    }
}
