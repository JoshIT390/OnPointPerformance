<div class="well bs-component">
    <form method="post" action="./" id="account_update">
        <legend style="font-weight: bold; color:#ffffff"></legend>
        <div class="form-group row">
            <label class="col-lg-2 control-label">First name </label>
            <div class="col-lg-8">
                <input type="text" name="firstName" value="' . $accountInformationResult[0] . '" required/>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-2 control-label">Last name </label>
            <div class="col-lg-8">
                <input type="text" name="lastName" value="' . $accountInformationResult[1] . '" required/>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-2 control-label">Address </label>
            <div class="col-lg-8">
                <input type="text" name="address" value="' . $accountInformationResult[2] . '" required/>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-2 control-label">City </label>
            <div class="col-lg-8">
                <input type="text" name="city" value="' . $accountInformationResult[3] . '" required/>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-2 control-label">State </label>
            <div class="col-lg-8">
                <select name="state">' . createStateAbbrevOptions($us_state_abbrevs, $accountInformationResult[4]) . '</select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-2 control-label">Zip code </label>
            <div class="col-lg-8">
                <input type="number" name="zip" value="' . $accountInformationResult[5] . '" maxlength="5" required/>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-2 control-label">Phone number </label>
            <div class="col-lg-8">
                <input type="tel" name="phone" value="' . $accountInformationResult[6] . '" pattern="(?:\(\d{3}\)|\d{3})[- ]?\d{3}[- ]?\d{4}" maxlength="13" required/>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-2 control-label">Email </label>
            <div class="col-lg-8">
                <input type="email" name="email" value="' . $accountInformationResult[7] . '" required/>
            </div>
        </div>
        <div>
            <input type="hidden" name="submit" value="TRUE">
            <input type="submit" value="Save changes" />
        </div>
    </form>
</div>';