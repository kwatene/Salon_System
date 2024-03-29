﻿using Salon_System.Models;
using System.ComponentModel.DataAnnotations;

namespace Salon_System.Controllers.ViewModels
{
    public class ServiceEmployee
    {
        [Key]
        public int ServiceId { get; set; }

        public Service? Service { get; set; }

        [Key]
        public int EmployeeId { get; set; }

        public Employee? Employee { get; set; }
    }
}
