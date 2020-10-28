<?php
declare(strict_types=1);

namespace App\Twig;

use App\Repository\UserRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension {

    private UserRepository $repo;

    public function __construct(UserRepository $repository) {
        $this->repo = $repository;
    }

    public function getFunctions(): array {
        return [
            new TwigFunction('count_users', [$this, 'countUsers']),
        ];
    }

    public function countUsers(): string {
        return $this->repo->countAll();
    }
}
