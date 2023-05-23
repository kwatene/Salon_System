using System.ComponentModel;

namespace Salon_System.Models
{
    public class User
    {
        public int Id { get; set; }
        [DisplayName("First Name")] public string? FirstName { get; set; }
        [DisplayName("Last Name")] public string? LastName { get; set; }
        [DisplayName("Gender")] public string? Gender { get; set; }
        [DisplayName("Date of Birth")] public DateTime? DateOfBirth { get; set; }
        [DisplayName("Email")] public string? Email { get; set; }
        [DisplayName("Phone")] public string? Phone { get; set; }
        [DisplayName("Address")] public string? Address { get; set; }
        [DisplayName("Suburb")] public string? Suburb { get; set; }
        [DisplayName("City")] public string? City { get; set; }
        [DisplayName("Country")] public string? Country { get; set; }
        [DisplayName("Postcode")] public string? PostCode { get; set; }

        //Display First Name and Last Name
        [DisplayName("Full Name")] public string FullName => FirstName + " " + LastName;

        //Display Phone as (###) ### ##### 
        [DisplayName("Mobile")] public string Mobile => Phone == null ? "" : "(" + Phone[..3] + ") " + Phone.Substring(3, 3) + " " + Phone[6..];

        //Parameterless Constructor
        public User() { }

        //Initialised Constructor all
        public User(int id, string? firstName, string? lastName, string? gender, DateTime? dateOfBirth, string? email, string? phone, string? address, string? suburb, string? city, string? country, string? postcode)
        {
            Id = id;
            FirstName = firstName;
            LastName = lastName;
            Gender = gender;
            DateOfBirth = dateOfBirth;
            Email = email;
            Phone = phone;
            Address = address;
            Suburb = suburb;
            City = city;
            Country = country;
            PostCode = postcode;
        }
    }
}
