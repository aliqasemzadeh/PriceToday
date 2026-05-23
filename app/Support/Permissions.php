<?php

namespace App\Support;

use App\Models\User;

class Permissions
{
    public const ADMINISTRATOR_ROLE = 'administrator';

    public const USER_PERMISSIONS = [
        'user-edit',
        'user-create',
        'user-delete',
    ];

    public const PLATFORM_PERMISSIONS = [
        'platform-edit',
        'platform-create',
        'platform-delete',
    ];

    /**
     * @return list<string>
     */
    public static function all(): array
    {
        return [...self::USER_PERMISSIONS, ...self::PLATFORM_PERMISSIONS];
    }

    public static function userCanAccessPanel(User $user): bool
    {
        return $user->hasRole(self::ADMINISTRATOR_ROLE)
            || $user->hasAnyPermission(self::all());
    }

    public static function userCanManageUsers(User $user): bool
    {
        return $user->hasRole(self::ADMINISTRATOR_ROLE)
            || $user->hasAnyPermission(self::USER_PERMISSIONS);
    }

    public static function userCanManagePlatforms(User $user): bool
    {
        return $user->hasRole(self::ADMINISTRATOR_ROLE)
            || $user->hasAnyPermission(self::PLATFORM_PERMISSIONS);
    }
}
