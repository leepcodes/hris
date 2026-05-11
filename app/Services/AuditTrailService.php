<?php

namespace App\Services;

use App\Models\AuditLog;

class AuditTrailService
{
    public function log(?int $actorId, string $action, string $module, ?string $entityType = null, ?int $entityId = null, mixed $oldValues = null, mixed $newValues = null, ?string $ipAddress = null, ?string $userAgent = null): void
    {
        AuditLog::query()->create([
            'actor_id' => $actorId,
            'action' => $action,
            'module' => $module,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
        ]);
    }
}
