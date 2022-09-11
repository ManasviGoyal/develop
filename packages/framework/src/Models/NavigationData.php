<?php

namespace Hyde\Framework\Models;

use Hyde\Framework\Concerns\JsonSerializesArrayable;
use Hyde\Framework\Contracts\FrontMatter\Support\NavigationSchema;
use Illuminate\Contracts\Support\Arrayable;

final class NavigationData implements NavigationSchema, Arrayable, \JsonSerializable
{
    use JsonSerializesArrayable;

    public ?string $label = null;
    public ?string $group = null;
    public ?bool $hidden = null;
    public ?int $priority = null;

    public function __construct(?string $label = null, ?string $group = null, ?bool $hidden = null, ?int $priority = null)
    {
        $this->label = $label;
        $this->group = $group;
        $this->hidden = $hidden;
        $this->priority = $priority;
    }

    public static function make(array $data): self
    {
        return new self(
            $data['label'] ?? null,
            $data['group'] ?? null,
            $data['hidden'] ?? null,
            $data['priority'] ?? null,
        );
    }

    public function label(): ?string
    {
        return $this->label;
    }

    public function group(): ?string
    {
        return $this->group;
    }

    public function hidden(): ?bool
    {
        return $this->hidden;
    }

    public function visible(): ?bool
    {
        return $this->hidden === null ? null : ! $this->hidden;
    }

    public function priority(): ?int
    {
        return $this->priority;
    }

    public function toArray(): array
    {
        return [
            'label' => $this->label,
            'group' => $this->group,
            'hidden' => $this->hidden,
            'priority' => $this->priority,
        ];
    }
}
