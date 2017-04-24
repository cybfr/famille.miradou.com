<?php
/**
 * @author Copyright (c) 2012 François-Régis Vuillemin (frv) <frv@miradou.com>
 *
 * This file is part of famille@miradou
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
$message [0]   = "Erreur";
$message [403] = '403 : Accès interdit.';
$message [404] = "404 : Ressource non trouvée.";
$message [405] = "405 :Méthode de requête non autorisée";
$message [406] = "Toutes les réponses possibles seront refusées.";
$message [407] = "Accès à la ressource autorisé par identification avec le proxy.";
$message [500] = 'Erreur interne';
?>
<script type="text/javascript">
$('.mainFrameTitle').html('<?=$message[$_REQUEST['error']];?>');
$('.mainFrameFooter').html('');
</script>
