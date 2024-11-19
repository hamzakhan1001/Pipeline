(function () {
  return function (parameters, TagManager) {
    this.fire = function () {

      var userDataObject = {};

      var email = parameters.get("email");
      var sha256EmailAddress = parameters.get("sha256_email_address");
      var phoneNumber = parameters.get("phone_number");
      var sha256PhoneNumber = parameters.get("sha256_phone_number");
      var addressFirstName = parameters.get("address_first_name");
      var addressSha256FirstName = parameters.get("address_sha256_first_name");
      var addressLastName = parameters.get("address_last_name");
      var addressSha256LastName = parameters.get("address_sha256_last_name");
      var addressStreet = parameters.get("address_street");
      var addressCity = parameters.get("address_city");
      var addressRegion = parameters.get("address_region");
      var addressPostalCode = parameters.get("address_postal_code");
      var addressCountry = parameters.get("address_country");

      if (email) {
        userDataObject.email = email;
      }

      if (sha256EmailAddress) {
        userDataObject.sha256_email_address = sha256EmailAddress;
      }

      if (phoneNumber) {
        userDataObject.phone_number = phoneNumber;
      }

      if (sha256PhoneNumber) {
        userDataObject.sha256_phone_number = sha256PhoneNumber;
      }

      if (addressFirstName || addressSha256FirstName || addressLastName || addressSha256LastName || addressStreet || addressCity || addressRegion || addressPostalCode || addressCountry) {
        userDataObject.address = {};
      }

      if (addressFirstName) {
        userDataObject.address.first_name = addressFirstName;
      }

      if (addressSha256FirstName) {
        userDataObject.address.sha256_first_name = addressSha256FirstName;
      }

      if (addressLastName) {
        userDataObject.address.last_name = addressLastName;
      }

      if (addressSha256LastName) {
        userDataObject.address.sha256_last_name = addressSha256LastName;
      }

      if (addressStreet) {
        userDataObject.address.street = addressStreet;
      }

      if (addressCity) {
        userDataObject.address.city = addressCity;
      }

      if (addressRegion) {
        userDataObject.address.region = addressRegion;
      }

      if (addressPostalCode) {
        userDataObject.address.postal_code = addressPostalCode;
      }

      if (addressCountry) {
        userDataObject.address.country = addressCountry;
      }


      window.dataLayer = window.dataLayer || [];

      function gtag() {
        window.dataLayer.push(arguments);
      }

      gtag("set", "user_data", userDataObject);

    };
  };
})();
