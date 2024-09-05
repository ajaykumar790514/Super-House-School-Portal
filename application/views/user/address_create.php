<input type="hidden" name="id" value="<?= @$address->id ?>">
<p id="edit-error-msg"></p>
 <div class="row">
    <div class="form-group col-sm-6">
        <label>Address Line 1<span class="required text-danger">*</span></label>
        <input type="text" name="address_line_1"  value="<?= @$address->address_line_1; ?>" required placeholder="Address Line 1" />
    </div>    
    <div class="form-group col-md-6">
        <label>Address Line 2 <span class="required text-danger">*</span></label>
        <input type="text" name="address_line_2"  value="<?= @$address->address_line_2; ?>" placeholder="Address Line 2" required="">
    </div>
    <div class="form-group col-md-6">
        <label>Address Line 3 ( optional )</label>
        <input type="text" name="address_line_3"  value="<?= @$address->address_line_3; ?>" placeholder="Address Line 3" >
    </div>
    <div class="form-group col-md-6">
        <label>Landmark ( optional ) </label>
        <input class="border-form-control" type="text" name="landmark" value="<?= @$address->landmark ?>" placeholder="Landmark" />
    </div>

    <div class="form-group col-sm-6">
        <label>Contact Person Name <span class="required text-danger">*</span></label>
        <input  type="text" name="contact_person_name"  value="<?= @$address->contact_person_name ?>" required placeholder="Contact Person" />
    </div>
    <div class="form-group col-sm-6">
        <label class="control-label">Mobile  Number <span class="required text-danger">*</span></label>
        <input  type="number" name="mobile"  value="<?= @$address->mobile ?>" required placeholder="Contact Number" />
    </div>
    <div class="form-group col-sm-6">
        <label class="control-label">Select State <span class="required text-danger">*</span></label>
        <select name="state" id="state"  class="select2 form-select border-form-control" onchange="fetch_city(this)" required>
            <option value="">--Select State--</option>
            <?php foreach($states as $s):?>
            <option value="<?=$s->id;?>"  data-id="<?= $s->id ?>" <?php if(@$address->state==$s->id){echo "selected";} ;?>  ><?=$s->name;?></option>
           <?php endforeach;?>     
        </select>
    </div>
    <div class="form-group col-sm-6">
        <label>City <span class="required text-danger">*</span></label>
        <select class="select2 form-select border-form-control city" name="city" required >
            <option value="<?= @$address->city ?>">
            <?= @$address->city_name ?>
            </option>
        </select>
    </div>
    <div class="form-group col-sm-6">
        <label>Pincode<span class="required text-danger">*</span></label>
        <input  type="number"  placeholder="Pincode" name="pincode" value="<?= @$address->pincode ?>" id="pin_code" oninput="validatePinCode(this)" minlength="6" maxlength="6"  required />
    </div>
    
</div>
<style>
    /* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
</style>
<!-- <script src="https://maps.google.com/maps/api/js?key=<?= $shop_detail->google_map_key; ?>&libraries=places&callback=initAutocomplete" async defer></script> -->
<script>
function validatePinCode(input) {
    // Remove leading zeros
    input.value = input.value.replace(/^0+/, '');

    // Ensure the value is within the range of six digits
    if (input.value.length > 6) {
        input.value = input.value.slice(0, 6);
    }

    // Validate if the input is a six-digit number
    var regex = /^\d{6}$/;
    if (!regex.test(input.value)) {
        input.setCustomValidity("Invalid PIN code");
    } else {
        input.setCustomValidity(""); // Clear the validation message
    }
}
</script>
<script>
    var markers = [];

function initAutocomplete() {
    var map = new google.maps.Map(document.getElementById('map'), {
      center: {lat: -33.8688, lng: 151.2195},
      zoom: 13,
      mapTypeId: 'roadmap'
    });

    var input = document.getElementById('pac-input');
    var searchBox = new google.maps.places.SearchBox(input);
    //map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);

    // Bias the SearchBox results towards current map's viewport.
    map.addListener('bounds_changed', function() {
      searchBox.setBounds(map.getBounds());
    });

    searchBox.addListener('places_changed', function() {
        var places = searchBox.getPlaces();

        if (places.length == 0) {
            return;
        }

        var bounds = new google.maps.LatLngBounds();
        places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
            var icon = {
              url: place.icon,
              size: new google.maps.Size(171, 171),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };

            // Create a marker for each place.
            var  markers = new google.maps.Marker({
              map: map,
              icon: icon,
              title: place.name,
              position: place.geometry.location,
              draggable:true,
             title:"Drag me!"
            });

            var latitude = place.geometry.location.lat();
            var longitude = place.geometry.location.lng();
            $('#latitude').val(latitude);
            $('#longitude').val(longitude);
            $('[name=house_no]').val(place.name);
            $('[name=address_l_2]').val(place.name);

            google.maps.event.addListener(markers, 'dragend', function(event) {
                var lat = event.latLng.lat();
                var lng = event.latLng.lng();
                $('#latitude').val(lat);
                $('#longitude').val(lng);
            });

            if (place.geometry.viewport) {
                bounds.union(place.geometry.viewport);
            } else {
                bounds.extend(place.geometry.location);
            }
        });
      map.fitBounds(bounds);
    });
}
</script>