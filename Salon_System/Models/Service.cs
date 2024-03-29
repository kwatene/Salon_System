﻿using Salon_System.Controllers.ViewModels;
using System.ComponentModel;
using System.ComponentModel.DataAnnotations;

namespace Salon_System.Models
{
    public class Service
    {
        [Key] public int Id { get; set; }

        [DisplayName("Name"), Required(ErrorMessage = "This field is required")] public string? Name { get; set; }

        [DisplayName("Description"), Required(ErrorMessage = "This field is required")] public string? Description { get; set; }

        [DisplayName("Duration"), Required(ErrorMessage = "This field is required")] public int DurationHours { get; set; }

        [DisplayName("Duration"), Required(ErrorMessage = "This field is required")] public int DurationMins { get; set; }

        [DisplayName("Charge"), Required(ErrorMessage = "This field is required")] public decimal? Charge { get; set; }

        [DisplayName("Category"), Required(ErrorMessage = "This field is required")] public int? CategoryId { get; set; }

        public string? CategoryName;                //Display name of Category associated to the service

        public List<String>? EmployeeNames = new(); //Display names of employees associated to the service

        [Required(ErrorMessage = "This field is required")]
        public List<int>? EmployeeIds = new();      //Get Ids of selected Employees to save in the database

        public ICollection<ServiceEmployee>? Employees { get; set; }


        //[DisplayName("Age Restricted")] public int? AgeRestricted { get; set; } //AgeRestriction??
        //public ConsentForm ConsentForm { get; set; }

        //Parameterless Constructor
        public Service(int id, string name, string desc, int dh, int dm, decimal charge, int cId, List<String> empNames)
        {
            Id = id;
            Name = name;
            Description = desc;
            DurationHours = dh;
            DurationMins = dm;
            Charge = charge;
            CategoryId = cId;
            EmployeeNames = empNames;
        }

        public Service() { }
    }
}
