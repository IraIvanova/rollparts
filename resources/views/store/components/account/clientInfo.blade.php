<div>
    <div class="row px-3">
        <div class="form-row form-row-wide validate-required w-50 @error('name') invalid @enderror">
            <label for="firstName" class="">{{ trans('interface.checkout.firstName') }}*</label>
            <input type="text" class="input-text rp-form-row-Input"
                   name="name"
                   id="firstName" value="{{$user->name ?? old('name') ?? ''}}">
        </div>
        <div class="form-row form-row-wide validate-required w-50 @error('lastName') invalid @enderror">
            <label for="lastName" class="">{{ trans('interface.checkout.lastName') }}*</label>
            <input type="text" class="input-text rp-form-row-Input"
                   name="lastName"
                   id="lastName"
                   value="{{$user->lastName ?? old('lastName') ?? ''}}">
        </div>
    </div>
    <div class="form-row form-row-wide validate-required @error('phone') invalid @enderror">
        <label for="phone" class="">{{ trans('interface.checkout.phone') }}*</label>
        <input type="text" class="input-text rp-form-row-Input"
               name="phone" pattern="^(\+?90)[0-9]{10}$" required
               id="phone" value="{{$user->phone ?? old('phone') ?? ''}}">
    </div>
    <div class="form-row form-row-wide validate-required @error('email') invalid @enderror">
        <label for="email" class="">Email*</label>
        <input type="email" class="input-text rp-form-row-Input"
               name="email"
               id="email" value="{{$user->email ?? old('email') ?? ''}}"
               @if(!$isCart) readonly @endif
               required>
    </div>
    <div class="form-row form-row-wide @if($isCart)validate-required @endif @error('identity') invalid @enderror">
        <label for="identity" class="">{{trans('interface.checkout.identityId')}} @if($isCart)* @endif</label>
        <input type="text" class="input-text rp-form-row-Input"
               name="identity"
               id="identity" value="{{$user->identity ?? old('identity') ?? ''}}"
               @if($isCart)required @endif>
    </div>
</div>
