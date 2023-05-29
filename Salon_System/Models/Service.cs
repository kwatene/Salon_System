using System.ComponentModel;
using System.ComponentModel.DataAnnotations;

namespace Salon_System.Models
{
    public class Service
    {
        public int Id { get; set; }

        [DisplayName("Name"), Required(ErrorMessage = "This field is required")] public string? Name { get; set; }

        [DisplayName("Description"), Required(ErrorMessage = "This field is required")] public string? Description { get; set; }

        [DisplayName("Duration"), Required(ErrorMessage = "This field is required")] public TimeSpan? Duration { get; set; }

        [DisplayName("Charge"), Required(ErrorMessage = "This field is required")] public decimal? Charge { get; set; }

        //[DisplayName("Age Restricted")] public int? AgeRestricted { get; set; } //AgeRestriction??

        //public List<Employee>? CapableEmployee { get; set; } //Assign capable Employees??

        /*
        //Assign Consent Form
        public ConsentForm ConsentForm { get; set; }

        //Assign ServiceCategory
        public ServiceCategory Category { get; set; }*/

        //Parameterless Constructor
        public Service() { }
    }
}
