<?php

class Utils {

    public static function isDisposableEmail($email) {
        $e = array(
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
            'zomg.info'
        );

        foreach ($e as $a) {
            if (strpos($email, $a)) {
                return TRUE;
            }
        }

        return FALSE;
    }

    public static function gitCommand($command, $repoPath = NULL) {
        if (!$repoPath) {
            $repoPath = getcwd();
        }

        $command = 'git --git-dir="' . $repoPath . '/.git" --work-tree="' . $repoPath . '" ' . $command;

        return Utils::runCommand($command);
    }

    public static function runCommand($command, $escape = TRUE) {
        // Escape special chars in string with a backslash
        if ($escape)
            $command = escapeshellcmd($command);
        exec($command, $output);

        return $output;
    }

    /**
     * Executes an Git command and returns the results.
     * if there is no output returns false.
     * $repo,
     * $username,
     * $password,
     *
     * @param type $arg
     */
    public static function gitGetBranches($repo, $username = NULL, $password = NULL) {
        $repo_url = parse_url($repo);

        if (!is_null($username)) {
            $repo_url['user'] = $username;
        }
        if (!is_null($password)) {
            $repo_url['pass'] = $password;
        }
        $repo = http_build_url($repo_url);

        if (trim($repo) == '') {
            return FALSE;
        }
        exec("git ls-remote --heads $repo", $op);
        if (empty($op)) return FALSE;

        foreach ($op as $k => $v) {
            $b = preg_split('/\s+/', $v);
            $b = explode('/', $b[1]);
            $op[$k] = $b[2];
        }

        return $op;
    }

    /**
     * Executes an Git command and returns the results.
     * if there is no output throw exception.
     * $repo,
     * $username,
     * $password,
     *
     * @param type $arg
     */
    public static function gitGetBranches2($repo, $username = NULL, $password = NULL) {
        $repo_url = parse_url($repo);
        if (!is_null($username)) {
            $repo_url['user'] = $username;
        }
        if (!is_null($password)) {
            $repo_url['pass'] = $password;
        }
        $repo = http_build_url($repo_url);
        if (trim($repo) == '') {
            return FALSE;
        }
        $process = new \Symfony\Component\Process\Process("git ls-remote --heads $repo");
        $process->run();
        $output = $process->getOutput();
        if (!$process->isSuccessful()) {
            $output = $process->getErrorOutput();
            if (preg_match('/authentication failed/', strtolower($output))) {
                throw new Exception('Unauthorized');
            }
            throw new Exception('Could not connect');
        }

        $lines = preg_split('/\\n/', $output);

        foreach ($lines as $k => $v) {
            if (trim($v) == '')
                continue;

            $b = preg_split('/\s+/', $v);
            $b = explode('/', $b[1]);
            $op[$k] = $b[2];
        }

        return $op;
    }

    /**
     * Get avatar of an email address.
     *
     * @param type $email
     * @param type $s
     * @param type $d
     * @param type $r
     * @param type $img
     * @param type $atts
     * @return string
     */
    public static function get_gravatar($email, $s = 80, $d = 'mm', $r = 'g', $img = FALSE, $atts = array()) {
        $url = protocol . '://www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($email)));
        $url .= "?s=$s&d=$d&r=$r";
        if ($img) {
            $url = '<img src="' . $url . '"';
            foreach ($atts as $key => $val) $url .= ' ' . $key . '="' . $val . '"';
            $url .= ' />';
        }

        return $url;
    }

    public static function startDeploy($deploy_id) {
        shell_exec('FUEL_ENV=' . \Fuel::$env . ' php /var/www/html/oil refine crontask:deploy2 ' . $deploy_id . ' > /dev/null 2>/dev/null &');
//        $process = new \Symfony\Component\Process\Process('FUEL_ENV=' . \Fuel::$env . ' php /var/www/html/oil refine crontask:deploy2 ' . $deploy_id);
//        $process->setTimeout(0);
//        $process->disableOutput();
//        $process->start(function ($something, $somethingelse) {
//
//        });
//        $pid = $process->getPid();
        logger(600, 'deploy start for ' . $deploy_id, __METHOD__);

        return TRUE;
    }

    /**
     * Test a ftp server, and if the path exists.
     *
     * @param $http_url
     * @throws Exception
     * @internal param type $a
     * @return string
     */

    public static function test_ftp($http_url) {
        try {
            $conn = new Banago\Bridge\Bridge($http_url);

            return TRUE;
        } catch (Exception $e) {
            $m = $e->getMessage();
            $m = explode(': ', $m);
            throw new Exception($m[count($m) - 1]);
        }
    }

    /**
     * Returns array
     * pushby
     * avatar_url
     * hash
     * post_data
     * commits
     *
     * @param type $input -> payload.
     * @return array
     */
    public static function parsePayload($i) {
        $service = 'none';

        if (isset($i['repository']['links']['self']['href'])) {
            if (preg_match('/bitbucket/i', $i['repository']['links']['self']['href'])) {
                $service = 'bitbucket';
//                utils::log('bitbucket');
            }
        }

        if (isset($i['repository'])) {
            if (isset($i['repository']['url'])) {
                if (preg_match('/github/i', $i['repository']['url'])) {
                    $service = 'github';
//                    utils::log('github');
                }
            }
        }

        if ($service == 'github') {
            $branch = $i['ref'];
            $branch = explode('/', $branch);
            $branch = $branch[count($branch) - 1];

            $commits = array();

            foreach ($i['commits'] as $commit) {
                $commits[] = array(
                    'hash'      => $commit['id'],
                    'message'   => $commit['message'],
                    'timestamp' => $commit['timestamp'],
                    'url'       => $commit['url'],
                    'committer' => $commit['committer'],
                );
            }

            return array(
                'user'       => $i['pusher']['name'],
                'avatar_url' => $i['sender']['avatar_url'],
                'hash'       => $i['after'],
                'post_data'  => serialize($i),
                'commits'    => serialize($commits),
                'branch'     => $branch
            );
        }

        // have to do same for bitbucket also
        if ($service == 'bitbucket') {

            $commits = array();
            $lc = count($i['push']['changes']) - 1;
            foreach ($i['push']['changes'] as $commit) {
                $commits[] = array(
                    'hash'      => $commit['new']['target']['hash'],
                    'message'   => $commit['new']['target']['message'],
                    'timestamp' => $commit['new']['target']['date'],
                    'url'       => $commit['links']['html']['href'],
                    'committer' => $commit['new']['target']['author']['user']['username'],
                );
            }

            $branch = $i['push']['changes'][$lc]['new']['name'];
            $avatar_url = $i['actor']['links']['avatar']['href'];
            $avatar_url = str_replace('32', '20', $avatar_url);

            return array(
                'user'       => $i['actor']['username'],
                'avatar_url' => $avatar_url,
                'hash'       => $i['push']['changes'][$lc]['new']['target']['hash'],
                'post_data'  => serialize($i),
                'commits'    => serialize($commits),
                'branch'     => $branch,
            );
        }
    }

    public static function parseProviderFromRepository($url) {
        if (preg_match('/bitbucket/', strtolower($url))) {
            return 'Bitbucket';
        }
        if (preg_match('/github/', strtolower($url))) {
            return 'Github';
        }
    }

    public static function humanize_data($bytes) {
        $decimals = 2;
        $sz = 'BKMGTP';
        $factor = floor((strlen($bytes) - 1) / 3);

        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
    }

    public static function strip_passwords($data) {
        foreach ($data as $k => $v) {
            if (isset($data[$k]['pass'])) {
                if (!empty($data[$k]['pass'])) {
                    $data[$k]['pset'] = TRUE;
                } else {
                    $data[$k]['pset'] = FALSE;
                }
                unset($data[$k]['pass']);
            }
            if (isset($data[$k]['password'])) {
                if (!empty($data[$k]['password'])) {
                    $data[$k]['pset'] = TRUE;
                } else {
                    $data[$k]['pset'] = FALSE;
                }
                unset($data[$k]['password']);
            }
        }

        return $data;
    }

    public static function log($string) {
        DB::insert('log')->set(array('a' => $string,))->execute();
    }

    public static function escapeHtmlChars($string, $except = array()) {
        if (is_array($string)) {
            foreach ($string as $k => $v) {
                if (!is_array($v) && $k !== 'password' && $k !== 'pass' && $k !== 'skip_path') {
                    $string[$k] = trim(htmlspecialchars($v, ENT_QUOTES));
                }
            }
        } else {
            $string = htmlspecialchars($string, ENT_QUOTES);
        }

        return $string;
    }

    public static function get_repo_dir($deploy_id, $user_id = NULL) {
        if (is_null($user_id)) {
            $user_id = Auth::get_user_id()[1];
        }

        return DOCROOT . 'fuel/repository/' . $user_id . '/' . $deploy_id;
    }

    public static function git_verify_hash($deploy_id, $hash) {
        $path = self::get_repo_dir($deploy_id);
        $origin = getcwd();
        chdir($path);
        $results = self::gitCommand('rev-parse --verify ' . $hash);
        chdir($origin);

        return (count($results)) ? $results[0] : FALSE;
    }
}

/* end of file auth.php */
