﻿using Salon_System.Controllers.ViewModels;
using System.ComponentModel;
using System.ComponentModel.DataAnnotations;

namespace Salon_System.Models
{
    public class Employee : User
    {
        [Key] public new int Id { get; set; }
        [DisplayName("Job Title"), Required(ErrorMessage = "This field is required")] public string? JobTitle { get; set; } //Employee needs a list of jobs??
        [DisplayName("Job Description")] public string? JobDesc { get; set; }
        [DisplayName("Hire Date")] public DateTime? HireDate { get; set; }
        public ICollection<ServiceEmployee>? Services { get; set; }


        //Parameterless Constructor
        public Employee() { }
        
        //Initialised Constructor Index
        public Employee(int id, string? firstName, string? lastName, string? jobTitle, string? jobDesc, DateTime? hireDate)
        {
            Id = id;
            FirstName = firstName;
            LastName = lastName;
            JobTitle = jobTitle;
            JobDesc = jobDesc;
            HireDate = hireDate;
        }

        //Initialised Constructor Create Get
        public Employee(int id, string? firstName, string? lastName)
        {
            Id = id;
            FirstName = firstName;
            LastName = lastName;
        }

        //Initialised Constructor Create Post
        public Employee(string? jobTitle, string? jobDesc, DateTime? hireDate, string? firstName, string? lastName, string? gender, DateTime? dob, string? email, string? phone, string? address, string? suburb, string? city, string? country, string? postcode)
        {
            JobTitle = jobTitle;
            JobDesc = jobDesc;
            HireDate = hireDate;
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

        //Initialised Constructor all
        public Employee(int id, string? firstName, string? lastName, string? gender, DateTime? dob, string? email, string? phone, string? address, string? suburb, string? city, string? country, string? postcode, string? jobTitle, string? jobDesc, DateTime? hireDate)
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
            JobTitle = jobTitle;
            JobDesc = jobDesc;
            HireDate = hireDate;
        }

    }
}
