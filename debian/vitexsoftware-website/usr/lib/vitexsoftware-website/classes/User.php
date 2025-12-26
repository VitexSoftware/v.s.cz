<?php

declare(strict_types=1);

/**
 * This file is part of the VitexSoftware package
 *
 * https://vitexsoftware.com/
 *
 * (c) Vítězslav Dvořák <http://vitexsoftware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace VSCZ;

use Ease\SQL\Orm;

/**
 * VitexSoftware Homepage - User Class.
 *
 * @author Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright  2015-2020 Vitex Software
 */
class User extends \Ease\User
{
    use Orm;
    public $useKeywords = [
        'login' => 'STRING',
        'firstname' => 'STRING',
        'lastname' => 'STRING',
        'email' => 'STRING',
    ];
    public $keywordsInfo = [
        'login' => [],
        'firstname' => [],
        'lastname' => [],
        'email' => [],
    ];

    /**
     * Tabulka uživatelů.
     */
    public string $myTable = 'user';

    /**
     * Sloupeček obsahující datum vložení záznamu do shopu.
     */
    public string $createColumn = 'DatCreate';

    /**
     * Slopecek obsahujici datum poslení modifikace záznamu do shopu.
     */
    public string $lastModifiedColumn = 'DatSave';

    /**
     * Klíčové slovo.
     */
    public string $keyword = 'user';

    public function __construct($userID = null)
    {
        $this->settingsColumn = 'settings';
        $this->nameColumn = 'login';

        parent::__construct($userID);
    }

    /**
     * Vrací odkaz na ikonu.
     *
     * @return string
     */
    public function getIcon(): string
    {
        $Icon = $this->GetSettingValue('icon');

        if (null === $Icon) {
            return parent::getIcon();
        }

        return $Icon;
    }

    /**
     * Vrací ID aktuálního záznamu.
     *
     * @return int
     */
    public function getId()
    {
        return (int) $this->getMyKey();
    }

    /**
     * Give you user name.
     *
     * @return string
     */
    public function getUserName(): string
    {
        $longname = trim($this->getDataValue('firstname').' '.$this->getDataValue('lastname'));

        if (\strlen($longname)) {
            return $longname;
        }

        return parent::getUserName();
    }

    public function getEmail(): string
    {
        return $this->getDataValue('email');
    }

    /**
     * Pokusí se o přihlášení.
     * Try to Sign in.
     *
     * @param array $formData pole dat z přihlaš. formuláře např. $_REQUEST
     *
     * @return null|bool
     */
    public function tryToLogin(array $formData): bool
    {
        if (empty($formData)) {
            return false;
        }

        $login = addslashes($formData[$this->loginColumn]);
        $password = addslashes($formData[$this->passwordColumn]);

        if (empty($login)) {
            $this->addStatusMessage(_('missing login'), 'error');

            return false;
        }

        if (empty($password)) {
            $this->addStatusMessage(_('missing password'), 'error');

            return false;
        }

        if ($this->loadFromSQL([$this->loginColumn => $login])) {
            $this->setObjectName();

            if (
                $this->passwordValidation(
                    $password,
                    $this->getDataValue($this->passwordColumn),
                )
            ) {
                if ($this->isAccountEnabled()) {
                    return $this->loginSuccess();
                }

                $this->userID = null;

                return false;
            }

            $this->userID = null;

            if (!empty($this->getData())) {
                $this->addStatusMessage(_('invalid password'), 'error');
            }

            $this->dataReset();

            return false;
        }

        $this->addStatusMessage(sprintf(
            _('user %s does not exist'),
            $login,
            'error',
        ));

        return false;
    }

    /**
     * Ověření hesla.
     *
     * @param string $plainPassword     heslo v nešifrované podobě
     * @param string $encryptedPassword šifrovné heslo
     *
     * @return bool
     */
    public static function passwordValidation($plainPassword, $encryptedPassword)
    {
        if ($plainPassword && $encryptedPassword) {
            $passwordStack = explode(':', $encryptedPassword);

            if (\count($passwordStack) !== 2) {
                return false;
            }

            if (md5($passwordStack[1].$plainPassword) === $passwordStack[0]) {
                return true;
            }
        }

        return false;
    }

    /**
     * Zašifruje heslo.
     *
     * @param string $plainTextPassword nešifrované heslo (plaintext)
     *
     * @return string Encrypted password
     */
    public static function encryptPassword($plainTextPassword)
    {
        $encryptedPassword = '';

        for ($i = 0; $i < 10; ++$i) {
            $encryptedPassword .= \Ease\Functions::randomNumber();
        }

        $passwordSalt = substr(md5($encryptedPassword), 0, 2);

        return md5($passwordSalt.$plainTextPassword).':'.$passwordSalt;
    }

    /**
     * Změní uživateli uložené heslo.
     *
     * @param string $newPassword nové heslo
     *
     * @return string password hash
     */
    public function passwordChange($newPassword)
    {
        return $this->dbsync([$this->passwordColumn => $this->encryptPassword($newPassword), $this->getKeyColumn() => $this->getUserID()]);
    }

    /**
     * Common instance of User class.
     *
     * @param null|mixed $user
     *
     * @return User
     */
    public static function singleton($user = null)
    {
        if (!isset(self::$instance)) {
            self::$instance = null === $user ? new self() : $user;
        }

        return self::$instance;
    }
}
