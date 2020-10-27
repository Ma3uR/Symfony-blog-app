<?php
declare(strict_types=1);

namespace App\Twig;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;


class AppExtension extends AbstractExtension {

    private UserRepository $repo;

    public function __construct(UserRepository $repository) {
        $this->repo = $repository;
    }

    public function getFunctions(): array {
        return [
            new TwigFunction('user', [$this, 'countByUsers']),
        ];
    }

    public function countByUsers(): string {
        $users = $this->repo->countByUsers();
        $users = implode(', ', array_map(
            static function ($v, $k) {
                if (is_array($v)) {
                    return implode('&' . $k . '', $v);
                }
                return $k . '' . $v;
            },
            $users,
            array_keys($users)
        ));

        return $users;

    }
}