<?php

namespace Gf;

/**
 * Class Utils
 * Contains small utility functions
 * that are used over the application many times.
 */
class Utils {

    /**
     * System directory separator.
     * will change the DS to the one that the OS understands
     *
     * @param $path
     *
     * @return mixed
     */
    public static function systemDS ($path) {
        $replace = "\\";
        if (DS == "\\")
            $replace = "/";

        return str_replace($replace, DS, $path);
    }

    public static function sqlGetFoundRows ($db = null) {
        $a = \DB::query("SELECT FOUND_ROWS() as c;")
            ->execute($db)
            ->as_array();

        return $a[0]['c'];
    }

    public static function sqlCalcRowInsert ($query) {
        $query = str_replace('SELECT', 'SELECT SQL_CALC_FOUND_ROWS', $query);

        return $query;
    }

    public static function asyncCall ($method, $data) {
        $url = home_url . 'api/async/' . $method . '/' . $data;
        $parts = parse_url($url);

        $port = 80;
        $protocol = '';
        if ($parts['scheme'] == 'https') {
            $protocol = 'ssl://';
            $port = 443;
        }

        $fp = fsockopen($protocol . $parts['host'], $port, $errno, $errstr, 30);
        $out = "GET " . $parts['path'] . " HTTP/1.1\r\n";
        $out .= "Host: " . $parts['host'] . "\r\n";
        $out .= "Connection: Close\r\n\r\n";
        fwrite($fp, $out);
        fclose($fp);
    }

    /**
     * Returns the MAJOR and MINOR version number
     *
     * @return string
     */
    public static function phpVersion () {
        $a = (float)phpversion();

        return number_format($a, 1);
    }

    /**
     * Executes a task in shell non-blocking
     *
     * @param        $task
     * @param string $param
     * @param string $output
     *
     * @return string
     */
    public static function executeTaskInBackground ($task, $param = '', $output = '/dev/null') {
        $a = "php " . DOCROOT . "oil r $task $param > $output &";

        return shell_exec($a);
    }

    /**
     * @param $bytes
     *
     * @return string
     */
    public static function humanize_data ($bytes) {
        $decimals = 2;
        $sz = 'BKMGTP';
        $factor = floor((strlen($bytes) - 1) / 3);

        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
    }

    /**
     * Logic to validate a UPC code.
     * todo: have to work on this but later.
     *
     * @param $code
     * @param $operator_id
     * @param $circle_id
     *
     * @return bool
     */
    public static function validateUPC ($code, $operator_id, $circle_id) {
        if (strlen($code) != 8)
            return false;
    }

    /**
     * generate a unique username from email.
     * Because we wont be using a username so forth.
     *
     * @param      $email
     * @param bool $appendRandomNumber
     *
     * @return string
     */
    public static function parseUsernameFromEmail ($email, $appendRandomNumber = true) {
        $a = substr($email, 0, strpos($email, '@'));
        if ($appendRandomNumber)
            $a .= \Str::random('numeric', 6);

        return preg_replace('/\./', '', $a);
    }

    /**
     * To check if a number or simno has only numbers.
     * Check in string because their length is 10+
     * todo: this gotta be removed. use the validation class instead.
     */
    public static function isStrNumber ($string) {
        return (preg_match('/^\d+$/', $string));
    }

    /**
     * Used for lineage and zones
     * converts arrays to -1-2-3-4-
     *
     * @param array $ar
     *
     * @return string
     */
    public static function _implodeAr ($ar = []) {
        if (gettype($ar) != 'array')
            $ar = '';
        if (count($ar) == 0)
            return '';

        return '-' . implode('-', $ar) . '-';
    }

    /**
     * Converts string -1-2-3-4- to array.
     *
     * @param string $ar
     *
     * @return array|string
     */
    public static function _explodeAr ($ar = '') {
        if (gettype($ar) != 'string')
            return [];
        $ar = explode('-', $ar);
        $ar = array_slice($ar, 1, count($ar) - 2);

        return $ar;
    }


    /**
     * creates a lineage to find the children.
     * if you have the current row's lineage and id,
     * for example: currentLineage is 1-2-3 and current id is 4.
     * This will return -1-2-3-4-% makes it easy to find with like clause
     *
     * @param $currentLineage
     * @param $next_id
     *
     * @return string
     */
    public static function createLineageToFindChildren ($currentLineage, $next_id) {
        if (gettype($currentLineage) == 'string') {
            $lineage = \Utils::_explodeAr($currentLineage);
        } else {
            $lineage = $currentLineage;
        }
        $lineage[] = $next_id;

        return \Utils::_implodeAr($lineage) . '%';
    }

    /**
     * implode array with extra , in between
     * todo: this function is not used anywhere. Why is it here.
     *
     * @param array $parr
     * @param array $carr
     *
     * @return string
     */
    public static function importArCoupon ($parr = [], $carr = []) {
        $tarr = [];
        foreach ($parr as $pk => $pv) {
            foreach ($carr as $ck => $cv) {
                array_push($tarr, $pv . ',' . $cv);
            }
        }

        return \Utils::_implodeAr($tarr);
    }

    /**
     * Category  Type Coupon
     *
     * @param $str
     *
     * @return array
     */
    public static function exportCategoryTypeCoupon ($str) {
        $ex1 = \Utils::_explodeAr($str);
        $temp = [];
        foreach ($ex1 as $pk => $pv) {
            $ar = explode(',', $pv);
            array_push($temp, $ar[1]);
        }

        return $temp;
    }

    /**
     * Get timestamp for now, this current second.
     *
     * @return int
     */
    public static function timeNow () {
        return time();
    }

    /**
     * Get timestamp for today morning 00:00
     */
    public static function timeToday () {
        $a = self::timeNow();
        $b = self::timestampToDate($a);
        $c = self::dateToTimestamp($b);

        return $c;
    }

    /**
     * Adds padding to a string. for example
     * addPadding(12, 4, 0) will result in 0012
     *
     * @param $string > string to add padding
     * @param $length > what should be the length of the string after adding padding
     * @param $char   > what char do you wanna add as padding
     *
     * @return string
     */
    public static function addPadding ($string, $length, $char) {
        $string = (String)$string;
        $curlen = strlen($string);
        if ($curlen > $length)
            return $string;
        $pL = $length - $curlen;
        $padding = '';
        for ($i = 0; $i < $pL; $i++) {
            $padding .= $char;
        }

        return $padding . $string;
    }

    /**
     * Date in format 2015-12-07
     *
     * @param $date
     *
     * @return int
     */
    public static function dateToTimestamp ($date) {
        $date = date_create($date);

        return date_timestamp_get($date);
    }

    /**
     * Alters time with key being the user friendly string
     * for example: '+2 days', '+1 second',
     *
     * @param      $key
     * @param null $time -> relative to this time.
     *
     * @return int
     */
    public static function timeAlter ($key, $time = null) {
        if (is_null($time))
            $time = self::timeNow();

        return strtotime($key, $time);
    }

    /**
     * Returns the days between the target.
     *
     * @param      $end
     * @param null $start
     *
     * @return float
     */
    public static function daysBetween ($end, $start = null) {
        if (is_null($start))
            $start = self::timeToday();
        $date_diff = $end - $start;

        return floor($date_diff / (60 * 60 * 24));
    }

    /**
     * Converts timestamp to fix date, without time.
     *
     * @param $timestamp
     *
     * @return string
     */
    public static function timestampToDate ($timestamp, $format = 'Y-m-d') {
        $date = new DateTime();
        $date->setTimestamp($timestamp);

        return $date->format($format);
    }

    public static function isDisposableEmail ($email) {
        $e = [
            '0-mail.com',
            '0815.ru',
            '0clickemail.com',
            '0wnd.net',
            '0wnd.org',
            '10minutemail.co.za',
            '10minutemail.com',
            '123-m.com',
            '1fsdfdsfsdf.tk',
            '1pad.de',
            '20minutemail.com',
            '21cn.com',
            '2fdgdfgdfgdf.tk',
            '2prong.com',
            '30minutemail.com',
            '33mail.com',
            '3d-painting.com',
            '3trtretgfrfe.tk',
            '4gfdsgfdgfd.tk',
            '4warding.com',
            '4warding.net',
            '4warding.org',
            '5ghgfhfghfgh.tk',
            '60minutemail.com',
            '675hosting.com',
            '675hosting.net',
            '675hosting.org',
            '6hjgjhgkilkj.tk',
            '6paq.com',
            '6url.com',
            '75hosting.com',
            '75hosting.net',
            '75hosting.org',
            '7tags.com',
            '9ox.net',
            'PutThisInYourSpamDatabase.com',
            'SendSpamHere.com',
            'SpamHereLots.com',
            'SpamHerePlease.com',
            'TempEMail.net',
            'a-bc.net',
            'afrobacon.com',
            'agedmail.com',
            'ajaxapp.net',
            'ama-trade.de',
            'amilegit.com',
            'amiri.net',
            'amiriindustries.com',
            'anonbox.net',
            'anonmails.de',
            'anonymbox.com',
            'antichef.com',
            'antichef.net',
            'antireg.ru',
            'antispam.de',
            'antispammail.de',
            'armyspy.com',
            'artman-conception.com',
            'azmeil.tk',
            'baxomale.ht.cx',
            'beefmilk.com',
            'bigstring.com',
            'binkmail.com',
            'bio-muesli.net',
            'bobmail.info',
            'bodhi.lawlita.com',
            'bofthew.com',
            'bootybay.de',
            'boun.cr',
            'bouncr.com',
            'breakthru.com',
            'brefmail.com',
            'broadbandninja.com',
            'bsnow.net',
            'bspamfree.org',
            'bugmenot.com',
            'bumpymail.com',
            'bund.us',
            'burstmail.info',
            'buymoreplays.com',
            'byom.de',
            'c2.hu',
            'card.zp.ua',
            'casualdx.com',
            'cek.pm',
            'centermail.com',
            'centermail.net',
            'chammy.info',
            'childsavetrust.org',
            'chogmail.com',
            'choicemail1.com',
            'clixser.com',
            'cmail.net',
            'cmail.org',
            'coldemail.info',
            'cool.fr.nf',
            'correo.blogos.net',
            'cosmorph.com',
            'courriel.fr.nf',
            'courrieltemporaire.com',
            'crapmail.org',
            'cubiclink.com',
            'curryworld.de',
            'cust.in',
            'cuvox.de',
            'd3p.dk',
            'dacoolest.com',
            'dandikmail.com',
            'dayrep.com',
            'dcemail.com',
            'deadaddress.com',
            'deadspam.com',
            'delikkt.de',
            'despam.it',
            'despammed.com',
            'devnullmail.com',
            'dfgh.net',
            'digitalsanctuary.com',
            'dingbone.com',
            'discardmail.com',
            'discardmail.de',
            'disposableaddress.com',
            'disposableemailaddresses.com',
            'disposableinbox.com',
            'dispose.it',
            'disposeamail.com',
            'disposemail.com',
            'dispostable.com',
            'dm.w3internet.co.ukexample.com',
            'dodgeit.com',
            'dodgit.com',
            'dodgit.org',
            'donemail.ru',
            'dontreg.com',
            'dontsendmespam.de',
            'drdrb.net',
            'dump-email.info',
            'dumpandjunk.com',
            'dumpmail.de',
            'dumpyemail.com',
            'e-mail.com',
            'e-mail.org',
            'e4ward.com',
            'easytrashmail.com',
            'einmalmail.de',
            'einrot.com',
            'eintagsmail.de',
            'email60.com',
            'emaildienst.de',
            'emailgo.de',
            'emailias.com',
            'emailigo.de',
            'emailinfive.com',
            'emaillime.com',
            'emailmiser.com',
            'emailsensei.com',
            'emailtemporanea.com',
            'emailtemporanea.net',
            'emailtemporar.ro',
            'emailtemporario.com.br',
            'emailthe.net',
            'emailtmp.com',
            'emailto.de',
            'emailwarden.com',
            'emailx.at.hm',
            'emailxfer.com',
            'emeil.in',
            'emeil.ir',
            'emz.net',
            'enterto.com',
            'ephemail.net',
            'ero-tube.org',
            'etranquil.com',
            'etranquil.net',
            'etranquil.org',
            'evopo.com',
            'explodemail.com',
            'express.net.ua',
            'eyepaste.com',
            'fakeinbox.com',
            'fakeinformation.com',
            'fansworldwide.de',
            'fantasymail.de',
            'fastacura.com',
            'fastchevy.com',
            'fastchrysler.com',
            'fastkawasaki.com',
            'fastmazda.com',
            'fastmitsubishi.com',
            'fastnissan.com',
            'fastsubaru.com',
            'fastsuzuki.com',
            'fasttoyota.com',
            'fastyamaha.com',
            'fightallspam.com',
            'filzmail.com',
            'fivemail.de',
            'fizmail.com',
            'fleckens.hu',
            'fr33mail.info',
            'frapmail.com',
            'friendlymail.co.uk',
            'front14.org',
            'fuckingduh.com',
            'fudgerub.com',
            'fux0ringduh.com',
            'fyii.de',
            'garliclife.com',
            'gehensiemirnichtaufdensack.de',
            'get1mail.com',
            'get2mail.fr',
            'getairmail.com',
            'getmails.eu',
            'getonemail.com',
            'getonemail.net',
            'ghosttexter.de',
            'giantmail.de',
            'girlsundertheinfluence.com',
            'gishpuppy.com',
            'gmial.com',
            'goemailgo.com',
            'gotmail.net',
            'gotmail.org',
            'gotti.otherinbox.com',
            'gowikibooks.com',
            'gowikicampus.com',
            'gowikicars.com',
            'gowikifilms.com',
            'gowikigames.com',
            'gowikimusic.com',
            'gowikinetwork.com',
            'gowikitravel.com',
            'gowikitv.com',
            'great-host.in',
            'greensloth.com',
            'grr.la',
            'gsrv.co.uk',
            'guerillamail.biz',
            'guerillamail.com',
            'guerillamail.net',
            'guerillamail.org',
            'guerrillamail.biz',
            'guerrillamail.com',
            'guerrillamail.de',
            'guerrillamail.info',
            'guerrillamail.net',
            'guerrillamail.org',
            'guerrillamailblock.com',
            'gustr.com',
            'h.mintemail.com',
            'h8s.org',
            'haltospam.com',
            'harakirimail.com',
            'hat-geld.de',
            'hatespam.org',
            'herp.in',
            'hidemail.de',
            'hidzz.com',
            'hmamail.com',
            'hochsitze.com',
            'hopemail.biz',
            'hotpop.com',
            'hulapla.de',
            'ieatspam.eu',
            'ieatspam.info',
            'ieh-mail.de',
            'ihateyoualot.info',
            'iheartspam.org',
            'ikbenspamvrij.nl',
            'imails.info',
            'inbax.tk',
            'inbox.si',
            'inboxalias.com',
            'inboxclean.com',
            'inboxclean.org',
            'incognitomail.com',
            'incognitomail.net',
            'incognitomail.org',
            'infocom.zp.ua',
            'insorg-mail.info',
            'instant-mail.de',
            'ip6.li',
            'ipoo.org',
            'irish2me.com',
            'iwi.net',
            'jetable.com',
            'jetable.fr.nf',
            'jetable.net',
            'jetable.org',
            'jnxjn.com',
            'jourrapide.com',
            'jsrsolutions.com',
            'junk1e.com',
            'kasmail.com',
            'kaspop.com',
            'keepmymail.com',
            'killmail.com',
            'killmail.net',
            'kir.ch.tc',
            'klassmaster.com',
            'klassmaster.net',
            'klzlk.com',
            'koszmail.pl',
            'kulturbetrieb.info',
            'kurzepost.de',
            'lawlita.com',
            'letthemeatspam.com',
            'lhsdv.com',
            'lifebyfood.com',
            'link2mail.net',
            'litedrop.com',
            'lol.ovpn.to',
            'lolfreak.net',
            'lookugly.com',
            'lopl.co.cc',
            'lortemail.dk',
            'lr78.com',
            'lroid.com',
            'lukop.dk',
            'm21.cc',
            'm4ilweb.info',
            'maboard.com',
            'mail-filter.com',
            'mail-temporaire.fr',
            'mail.by',
            'mail.mezimages.net',
            'mail.zp.ua',
            'mail1a.de',
            'mail21.cc',
            'mail2rss.org',
            'mail333.com',
            'mail4trash.com',
            'mailbidon.com',
            'mailbiz.biz',
            'mailblocks.com',
            'mailbucket.org',
            'mailcat.biz',
            'mailcatch.com',
            'mailde.de',
            'mailde.info',
            'maildrop.cc',
            'maileater.com',
            'maileimer.de',
            'mailexpire.com',
            'mailfa.tk',
            'mailforspam.com',
            'mailfreeonline.com',
            'mailguard.me',
            'mailin8r.com',
            'mailinater.com',
            'mailinator.com',
            'mailinator.net',
            'mailinator.org',
            'mailinator2.com',
            'mailincubator.com',
            'mailismagic.com',
            'mailme.ir',
            'mailme.lv',
            'mailme24.com',
            'mailmetrash.com',
            'mailmoat.com',
            'mailms.com',
            'mailnator.com',
            'mailnesia.com',
            'mailnull.com',
            'mailorg.org',
            'mailpick.biz',
            'mailrock.biz',
            'mailscrap.com',
            'mailshell.com',
            'mailsiphon.com',
            'mailslite.com',
            'mailtemp.info',
            'mailtome.de',
            'mailtothis.com',
            'mailtrash.net',
            'mailtv.net',
            'mailtv.tv',
            'mailzilla.com',
            'mailzilla.org',
            'makemetheking.com',
            'manybrain.com',
            'mbx.cc',
            'mega.zik.dj',
            'meinspamschutz.de',
            'meltmail.com',
            'messagebeamer.de',
            'mezimages.net',
            'mierdamail.com',
            'ministry-of-silly-walks.de',
            'mintemail.com',
            'misterpinball.de',
            'moburl.com',
            'moncourrier.fr.nf',
            'monemail.fr.nf',
            'monmail.fr.nf',
            'monumentmail.com',
            'msa.minsmail.com',
            'mt2009.com',
            'mt2014.com',
            'mx0.wwwnew.eu',
            'mycard.net.ua',
            'mycleaninbox.net',
            'mymail-in.net',
            'mypacks.net',
            'mypartyclip.de',
            'myphantomemail.com',
            'mysamp.de',
            'myspaceinc.com',
            'myspaceinc.net',
            'myspaceinc.org',
            'myspacepimpedup.com',
            'myspamless.com',
            'mytempemail.com',
            'mytempmail.com',
            'mytrashmail.com',
            'nabuma.com',
            'neomailbox.com',
            'nepwk.com',
            'nervmich.net',
            'nervtmich.net',
            'netmails.com',
            'netmails.net',
            'netzidiot.de',
            'neverbox.com',
            'nice-4u.com',
            'nincsmail.hu',
            'nnh.com',
            'no-spam.ws',
            'noblepioneer.com',
            'nobulk.com',
            'noclickemail.com',
            'nogmailspam.info',
            'nomail.pw',
            'nomail.xl.cx',
            'nomail2me.com',
            'nomorespamemails.com',
            'nospam.ze.tc',
            'nospam4.us',
            'nospamfor.us',
            'nospammail.net',
            'nospamthanks.info',
            'notmailinator.com',
            'nowhere.org',
            'nowmymail.com',
            'nurfuerspam.de',
            'nus.edu.sg',
            'nwldx.com',
            'objectmail.com',
            'obobbo.com',
            'odnorazovoe.ru',
            'oneoffemail.com',
            'onewaymail.com',
            'onlatedotcom.info',
            'online.ms',
            'oopi.org',
            'opayq.com',
            'ordinaryamerican.net',
            'otherinbox.com',
            'ourklips.com',
            'outlawspam.com',
            'ovpn.to',
            'owlpic.com',
            'pancakemail.com',
            'pcusers.otherinbox.com',
            'pimpedupmyspace.com',
            'pjjkp.com',
            'plexolan.de',
            'poczta.onet.pl',
            'politikerclub.de',
            'poofy.org',
            'pookmail.com',
            'privacy.net',
            'privatdemail.net',
            'proxymail.eu',
            'prtnx.com',
            'punkass.com',
            'putthisinyourspamdatabase.com',
            'qq.com',
            'quickinbox.com',
            'rcpt.at',
            'reallymymail.com',
            'realtyalerts.ca',
            'recode.me',
            'recursor.net',
            'regbypass.com',
            'regbypass.comsafe-mail.net',
            'rejectmail.com',
            'reliable-mail.com',
            'rhyta.com',
            'rklips.com',
            'rmqkr.net',
            'royal.net',
            'rppkn.com',
            'rtrtr.com',
            's0ny.net',
            'safe-mail.net',
            'safersignup.de',
            'safetymail.info',
            'safetypost.de',
            'sandelf.de',
            'saynotospams.com',
            'schafmail.de',
            'schrott-email.de',
            'secretemail.de',
            'secure-mail.biz',
            'selfdestructingmail.com',
            'senseless-entertainment.com',
            'services391.com',
            'sharklasers.com',
            'shieldemail.com',
            'shiftmail.com',
            'shitmail.me',
            'shitware.nl',
            'shmeriously.com',
            'shortmail.net',
            'sibmail.com',
            'sinnlos-mail.de',
            'skeefmail.com',
            'slapsfromlastnight.com',
            'slaskpost.se',
            'slopsbox.com',
            'smashmail.de',
            'smellfear.com',
            'snakemail.com',
            'sneakemail.com',
            'sneakmail.de',
            'snkmail.com',
            'sofimail.com',
            'sofort-mail.de',
            'sogetthis.com',
            'solvemail.info',
            'soodonims.com',
            'spam.la',
            'spam.su',
            'spam4.me',
            'spamail.de',
            'spamarrest.com',
            'spamavert.com',
            'spambob.com',
            'spambob.net',
            'spambob.org',
            'spambog.com',
            'spambog.de',
            'spambog.ru',
            'spambox.info',
            'spambox.irishspringrealty.com',
            'spambox.us',
            'spamcannon.com',
            'spamcannon.net',
            'spamcero.com',
            'spamcon.org',
            'spamcorptastic.com',
            'spamcowboy.com',
            'spamcowboy.net',
            'spamcowboy.org',
            'spamday.com',
            'spamex.com',
            'spamfree.eu',
            'spamfree24.com',
            'spamfree24.de',
            'spamfree24.eu',
            'spamfree24.info',
            'spamfree24.net',
            'spamfree24.org',
            'spamgoes.in',
            'spamgourmet.com',
            'spamgourmet.net',
            'spamgourmet.org',
            'spamherelots.com',
            'spamhereplease.com',
            'spamhole.com',
            'spamify.com',
            'spaminator.de',
            'spamkill.info',
            'spaml.com',
            'spaml.de',
            'spammotel.com',
            'spamobox.com',
            'spamoff.de',
            'spamslicer.com',
            'spamspot.com',
            'spamthis.co.uk',
            'spamthisplease.com',
            'spamtrail.com',
            'spamtroll.net',
            'speed.1s.fr',
            'spoofmail.de',
            'stuffmail.de',
            'super-auswahl.de',
            'supergreatmail.com',
            'supermailer.jp',
            'superrito.com',
            'superstachel.de',
            'suremail.info',
            'talkinator.com',
            'teewars.org',
            'teleworm.com',
            'teleworm.us',
            'temp-mail.org',
            'temp-mail.ru',
            'tempalias.com',
            'tempe-mail.com',
            'tempemail.biz',
            'tempemail.co.za',
            'tempemail.com',
            'tempemail.net',
            'tempinbox.co.uk',
            'tempinbox.com',
            'tempmail.eu',
            'tempmail.it',
            'tempmail2.com',
            'tempmaildemo.com',
            'tempmailer.com',
            'tempmailer.de',
            'tempomail.fr',
            'temporarily.de',
            'temporarioemail.com.br',
            'temporaryemail.net',
            'temporaryforwarding.com',
            'temporaryinbox.com',
            'temporarymailaddress.com',
            'tempthe.net',
            'thanksnospam.info',
            'thankyou2010.com',
            'thc.st',
            'thelimestones.com',
            'thisisnotmyrealemail.com',
            'thismail.net',
            'throwawayemailaddress.com',
            'tilien.com',
            'tittbit.in',
            'tizi.com',
            'tmailinator.com',
            'toomail.biz',
            'topranklist.de',
            'tradermail.info',
            'trash-amil.com',
            'trash-mail.at',
            'trash-mail.com',
            'trash-mail.de',
            'trash2009.com',
            'trashdevil.com',
            'trashemail.de',
            'trashmail.at',
            'trashmail.com',
            'trashmail.de',
            'trashmail.me',
            'trashmail.net',
            'trashmail.org',
            'trashmail.ws',
            'trashmailer.com',
            'trashymail.com',
            'trashymail.net',
            'trialmail.de',
            'trillianpro.com',
            'turual.com',
            'twinmail.de',
            'tyldd.com',
            'uggsrock.com',
            'umail.net',
            'upliftnow.com',
            'uplipht.com',
            'uroid.com',
            'us.af',
            'venompen.com',
            'veryrealemail.com',
            'viditag.com',
            'viewcastmedia.com',
            'viewcastmedia.net',
            'viewcastmedia.org',
            'viralplays.com',
            'vpn.st',
            'vsimcard.com',
            'vubby.com',
            'wasteland.rfc822.org',
            'webemail.me',
            'webm4il.info',
            'weg-werf-email.de',
            'wegwerf-emails.de',
            'wegwerfadresse.de',
            'wegwerfemail.com',
            'wegwerfemail.de',
            'wegwerfmail.de',
            'wegwerfmail.info',
            'wegwerfmail.net',
            'wegwerfmail.org',
            'wetrainbayarea.com',
            'wetrainbayarea.org',
            'wh4f.org',
            'whyspam.me',
            'willhackforfood.biz',
            'willselfdestruct.com',
            'winemaven.info',
            'wronghead.com',
            'wuzup.net',
            'wuzupmail.net',
            'www.e4ward.com',
            'www.gishpuppy.com',
            'www.mailinator.com',
            'wwwnew.eu',
            'x.ip6.li',
            'xagloo.com',
            'xemaps.com',
            'xents.com',
            'xmaily.com',
            'xoxy.net',
            'yep.it',
            'yogamaven.com',
            'yopmail.com',
            'yopmail.fr',
            'yopmail.net',
            'yourdomain.com',
            'ypmail.webarnak.fr.eu.org',
            'yuurok.com',
            'z1p.biz',
            'za.com',
            'zehnminuten.de',
            'zehnminutenmail.de',
            'zippymail.info',
            'zoaxe.com',
            'zoemail.net',
            'zoemail.org',
            'zomg.info',
            '33mail.com',
            'maildrop.cc',
            'inboxalias.com',
            'spam4.me',
            'koszmail.pl',
            'tagyourself.com',
            'whatpaas.com',
            'lackmail.ru',
            'smap4.me',
            'pokemail.net',
            'throwam.com',
            'ze.gally.jp',
            '20mail.it',
            '20email.eu',
            'my10minutemail.com',
            'yomail.info',
            'swift10minutemail.com',
            '10minutemail.co.uk',
            'armyspy.com',
            'cuvox.de',
            'dayrep.com',
            'einrot.com',
            'fleckens.hu',
            'gustr.com',
            'jourrapide.com',
            'rhzla.com',
            'superrito.com',
            'teleworm.us',
            'hmamail.com',
            'ho3twwn.com',
            'boximail.com',
            'maildrop.cc',
        ];

        foreach ($e as $a) {
            if (strpos($email, $a)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get avatar of an email address.
     *
     * @param type        $email
     * @param int         $size
     * @param string      $default
     * @param string|type $r
     * @param bool|type   $img
     * @param array       $attributes
     *
     * @return string
     */
    public static function get_gravatar ($email, $size = 80, $default = 'mm', $r = 'g', $img = false, $attributes = []) {
        $url = protocol . '://www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($email))) . '?';
        $url .= \Fuel\Core\Uri::build_query_string([
            's' => $size,
            'd' => $default,
            'r' => $r,
        ]);

        if ($img) {
            $url = '<img src="' . $url . '"';
            foreach ($attributes as $key => $val)
                $url .= ' ' . $key . '="' . $val . '"';
            $url .= ' />';
        }

        return $url;
    }

}

/* end of file utils.php */
