using System.ComponentModel;

namespace Salon_System.Models
{
    public class Service
    {
        public int Id { get; set; }

        [DisplayName("Name")] public string? Name { get; set; }

        [DisplayName("Description")] public string? Description { get; set; }

        [DisplayName("Charge")] public float? Charge { get; set; }

        [DisplayName("Duration")] public DateTime? Duration { get; set; }

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
