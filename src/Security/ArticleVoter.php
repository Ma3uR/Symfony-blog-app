<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\Article;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class ArticleVoter extends Voter {
    public const EDIT = 'edit';
    private Security $security;

    public function __construct(Security $security) {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool {
        if ($attribute !== self::EDIT) {
            return false;
        }

        if (!$subject instanceof Article) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        /** @var Article $article */
        $article = $subject;

        return $this->canEdit($article, $user);
    }

    private function canEdit(Article $article, User $user): bool {

        return $user === $article->getAuthor();
    }
}
