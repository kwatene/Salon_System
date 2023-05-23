using System.ComponentModel;

namespace Salon_System.Models
{
    public class Client : User
    {
        public new int Id { get; set; }


        //Parameterless Constructor
        public Client() { }

        //Initialised Constructor all
        public Client(int id,  string? firstName, string? lastName, string? gender, DateTime? dob, string? email, string? phone, string? address, string? suburb, string? city, string? country, string? postcode)
        {
            Id = id;
            FirstName = firstName;
            LastName = lastName;
            Gender = gender;
            DateOfBirth = dob;
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