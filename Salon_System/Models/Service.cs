using System.ComponentModel;
using System.ComponentModel.DataAnnotations;

namespace Salon_System.Models
{
    public class Service
    {
        public int Id { get; set; }

        [DisplayName("Name"), Required(ErrorMessage = "This field is required")] public string? Name { get; set; }

        [DisplayName("Description"), Required(ErrorMessage = "This field is required")] public string? Description { get; set; }

        [DisplayName("Duration"), Required(ErrorMessage = "This field is required")] public int DurationHours { get; set; }

        [DisplayName("Duration"), Required(ErrorMessage = "This field is required")] public int DurationMins { get; set; }

        [DisplayName("Charge"), Required(ErrorMessage = "This field is required")] public decimal? Charge { get; set; }

        [DisplayName("Category")] public int? Category { get; set; }

        //[DisplayName("Capable Staff"), Required(ErrorMessage = "This field is required")] public List<int>? CapableStaff { get; set; }

        //[DisplayName("Age Restricted")] public int? AgeRestricted { get; set; } //AgeRestriction??
        //public ConsentForm ConsentForm { get; set; }

        //Parameterless Constructor
        public Service() { }
    }
}
