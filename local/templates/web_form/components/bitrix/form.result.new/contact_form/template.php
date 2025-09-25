<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>

<?if ($arResult["isFormNote"] == "Y"):?>
    <div class="contact-form__success-note">
        <?=$arResult["FORM_NOTE"]?>
    </div>
<?endif;?>

<?if ($arResult["isFormNote"] != "Y"):?>

<div class="contact-form">
    <div class="contact-form__head">
        <div class="contact-form__head-title">Связаться</div>
        <div class="contact-form__head-text">Наши сотрудники помогут выполнить подбор услуги и&nbsp;расчет цены с&nbsp;учетом ваших требований</div>
    </div>

    <?if ($arResult["isFormErrors"] == "Y"):?>
        <div class="contact-form__error-summary">
            <?=$arResult["FORM_ERRORS_TEXT"];?>
        </div>
    <?endif;?>

    <?=$arResult["FORM_HEADER"]?>

        <div class="contact-form__form-inputs">
            <?
            $sid = "USER_NAME";
            $arQuestion = $arResult["QUESTIONS"][$sid];
            if($arQuestion){
                $inputName = 'form_' . $arQuestion['STRUCTURE'][0]['FIELD_TYPE'] . '_' . $arQuestion['STRUCTURE'][0]['ID'];
                $inputValue = isset($arResult['arrVALUES'][$inputName]) ? htmlspecialcharsbx($arResult['arrVALUES'][$inputName]) : '';
            ?>
            <div class="input contact-form__input">
                <label class="input__label" for="medicine_name">
                    <div class="input__label-text"><?=$arQuestion["CAPTION"]?><?if($arQuestion["REQUIRED"] == "Y"):?>*<?endif;?></div>
                    <input class="input__input" type="text" id="medicine_name" name="<?=$inputName?>" value="<?=$inputValue?>" <?if($arQuestion["REQUIRED"] == "Y"):?>required=""<?endif;?>>
                    <?if(!empty($arResult["FORM_ERRORS"][$sid])):?>
                    <div class="input__notification"><?=$arResult["FORM_ERRORS"][$sid];?></div><?endif;?>
                </label>
            </div>
            <?
            }

            $sid = "USER_COMPANY";
            $arQuestion = $arResult["QUESTIONS"][$sid];
            if($arQuestion){
                $inputName = 'form_' . $arQuestion['STRUCTURE'][0]['FIELD_TYPE'] . '_' . $arQuestion['STRUCTURE'][0]['ID'];
                $inputValue = isset($arResult['arrVALUES'][$inputName]) ? htmlspecialcharsbx($arResult['arrVALUES'][$inputName]) : '';
            ?>
            <div class="input contact-form__input">
                <label class="input__label" for="medicine_company">
                    <div class="input__label-text"><?=$arQuestion["CAPTION"]?><?if($arQuestion["REQUIRED"] == "Y"):?>*<?endif;?></div>
                    <input class="input__input" type="text" id="medicine_company" name="<?=$inputName?>" value="<?=$inputValue?>" <?if($arQuestion["REQUIRED"] == "Y"):?>required=""<?endif;?>>
                    <?if(!empty($arResult["FORM_ERRORS"][$sid])):?>
                    <div class="input__notification"><?=$arResult["FORM_ERRORS"][$sid];?></div><?endif;?>
                </label>
            </div>
            <?
            }

            $sid = "USER_EMAIL";
            $arQuestion = $arResult["QUESTIONS"][$sid];
            if ($arQuestion) {
                $inputName = 'form_' . $arQuestion['STRUCTURE'][0]['FIELD_TYPE'] . '_' . $arQuestion['STRUCTURE'][0]['ID'];
                $inputValue = isset($arResult['arrVALUES'][$inputName]) ? htmlspecialcharsbx($arResult['arrVALUES'][$inputName]) : '';
            ?>
            <div class="input contact-form__input">
                <label class="input__label" for="medicine_email">
                    <div class="input__label-text"><?=$arQuestion["CAPTION"]?><?if($arQuestion["REQUIRED"] == "Y"):?>*<?endif;?></div>
                    <input class="input__input" type="email" id="medicine_email" name="<?=$inputName?>" value="<?=$inputValue?>" <?if($arQuestion["REQUIRED"] == "Y"):?>required=""<?endif;?>>
                    <?if(!empty($arResult["FORM_ERRORS"][$sid])):?>
                    <div class="input__notification"><?=$arResult["FORM_ERRORS"][$sid];?></div><?endif;?>
                </label>
            </div>
            <?
            }

            $sid = "USER_PHONE";
            $arQuestion = $arResult["QUESTIONS"][$sid];
            if ($arQuestion) {
                $inputName = 'form_' . $arQuestion['STRUCTURE'][0]['FIELD_TYPE'] . '_' . $arQuestion['STRUCTURE'][0]['ID'];
                $inputValue = isset($arResult['arrVALUES'][$inputName]) ? htmlspecialcharsbx($arResult['arrVALUES'][$inputName]) : '';
            ?>
            <div class="input contact-form__input">
                <label class="input__label" for="medicine_phone">
                    <div class="input__label-text"><?=$arQuestion["CAPTION"]?><?if($arQuestion["REQUIRED"] == "Y"):?>*<?endif;?></div>
                    <input class="input__input" type="tel" id="medicine_phone" name="<?=$inputName?>" value="<?=$inputValue?>" <?if($arQuestion["REQUIRED"] == "Y"):?>required=""<?endif;?>
                           data-inputmask="'mask': '+79999999999', 'clearIncomplete': 'true'" maxlength="12" x-autocompletetype="phone-full">
                    <?if(!empty($arResult["FORM_ERRORS"][$sid])):?>
                    <div class="input__notification"><?=$arResult["FORM_ERRORS"][$sid];?></div><?endif;?>
                </label>
            </div>
            <?
            }
            ?>
        </div>

        <div class="contact-form__form-message">
            <?
            $sid = "MESSAGE";
            $arQuestion = $arResult["QUESTIONS"][$sid];
            if ($arQuestion) {
                $inputName = 'form_' . $arQuestion['STRUCTURE'][0]['FIELD_TYPE'] . '_' . $arQuestion['STRUCTURE'][0]['ID'];
                $inputValue = isset($arResult['arrVALUES'][$inputName]) ? htmlspecialcharsbx($arResult['arrVALUES'][$inputName]) : '';
            ?>
            <div class="input">
                <label class="input__label" for="medicine_message">
                    <div class="input__label-text"><?=$arQuestion["CAPTION"]?><?if($arQuestion["REQUIRED"] == "Y"):?>*<?endif;?></div>
                    <textarea class="input__input" id="medicine_message" name="<?=$inputName?>" <?if($arQuestion["REQUIRED"] == "Y"):?>required=""<?endif;?>><?=$inputValue?></textarea>
                    <?if(!empty($arResult["FORM_ERRORS"][$sid])):?>
                    <div class="input__notification"><?=$arResult["FORM_ERRORS"][$sid];?></div><?endif;?>
                </label>
            </div>
            <?
            }
            ?>
        </div>

        <div class="contact-form__bottom">
            <div class="contact-form__bottom-policy">Нажимая &laquo;Отправить&raquo;, Вы&nbsp;подтверждаете, что ознакомлены, полностью согласны и&nbsp;принимаете условия &laquo;Согласия на&nbsp;обработку персональных данных&raquo;.</div>

            <button class="form-button contact-form__bottom-button" type="submit" name="web_form_submit" value="Y">
                <div class="form-button__title">
                    <?=htmlspecialcharsbx(trim($arResult["arForm"]["BUTTON"]) == '' ? "Оставить заявку" : $arResult["arForm"]["BUTTON"]);?>
                </div>
            </button>
        </div>

    <?=$arResult["FORM_FOOTER"]?>
</div>
<?endif;?>