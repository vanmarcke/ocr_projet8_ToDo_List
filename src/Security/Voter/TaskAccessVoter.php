<?php

namespace App\Security\Voter;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class TaskAccessVoter extends Voter
{
    /**
     * @var Security
     */
    public function __construct(private Security $security)
    {
    }

    /**
     * {@inheritdoc}
     */
    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return \in_array($attribute, ['TASK_DELETE'], true)
            && $subject instanceof \App\Entity\Task;
    }

    /**
     * {@inheritdoc}
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        /** @var Task $task */
        $task = $subject;

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'TASK_DELETE':
                return $this->canDelete($task, $user);
                break;
        }

        return false;
    }

    /**
     * @param Task $task contains task information
     * @param User $user contains user information
     *
     * @return bool
     */
    private function canDelete(Task $task, User $user): bool
    {
        if ($this->security->isGranted('ROLE_ADMIN') && (null === $task->getAuthor())) {
            return true;
        }

        return $user === $task->getAuthor();
    }
}
