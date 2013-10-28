<?php
/* (c) Anton Medvedev <anton@elfet.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Chat\Form\Transformer;

use Chat\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class UserTransformer implements DataTransformerInterface
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Transforms an object (user) to a string (number).
     *
     * @param  User|null $user
     * @return string
     */
    public function transform($user)
    {
        if (null === $user) {
            return "";
        }

        return $user->getId();
    }

    /**
     * Transforms a string (number) to an object (user).
     *
     * @param  string $id
     *
     * @return User|null
     *
     * @throws TransformationFailedException if object (issue) is not found.
     */
    public function reverseTransform($id)
    {
        if (!$id) {
            return null;
        }

        $user = $this->em
            ->getRepository('Chat\Entity\User')
            ->findOneBy(array('id' => $id))
        ;

        if (null === $user) {
            throw new TransformationFailedException(sprintf(
                'An user with id "%s" does not exist!',
                $id
            ));
        }

        return $user;
    }
}