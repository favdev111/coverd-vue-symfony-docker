<?php

namespace App\Security;

use App\Entity\Supplier;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class SupplierVoter extends Voter
{
    public const EDIT = 'EDIT';
    public const VIEW = 'VIEW';

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [self::VIEW, self::EDIT])) {
            return false;
        }

        if (!$subject instanceof Supplier) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        $supplier = $subject;

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($supplier, $user);
            case self::EDIT:
                return $this->canEdit($supplier, $user);
            default:
                throw new \LogicException('This code should not be reached!');
        }
    }

    private function canView(Supplier $supplier, User $user)
    {
        if ($this->canEdit($supplier, $user)) {
            return true;
        }

        if ($user->hasRole(Supplier::ROLE_VIEW)) {
            return true;
        }

        return false;
    }

    private function canEdit(Supplier $supplier, User $user)
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->hasRole(Supplier::ROLE_EDIT)) {
            return true;
        }

        return false;
    }
}
