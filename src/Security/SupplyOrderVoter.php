<?php

namespace App\Security;

use App\Entity\Orders\SupplyOrder;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class SupplyOrderVoter extends Voter
{
    public const VIEW = 'VIEW';
    public const EDIT = 'EDIT';

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [self::VIEW, self::EDIT])) {
            return false;
        }

        if (!$subject instanceof SupplyOrder) {
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

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($subject, $user);
            case self::EDIT:
                return $this->canEdit($subject, $user);
            default:
                throw new \LogicException('This code should not be reached!');
        }
    }

    private function canView(SupplyOrder $supplyOrder, User $user)
    {
        if ($this->canEdit($supplyOrder, $user)) {
            return true;
        }

        if ($user->hasRole(SupplyOrder::ROLE_VIEW)) {
            return true;
        }

        return false;
    }

    private function canEdit(SupplyOrder $supplyOrder, User $user)
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->hasRole(SupplyOrder::ROLE_EDIT)) {
            return true;
        }

        return false;
    }
}
