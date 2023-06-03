using System.ComponentModel.DataAnnotations;

namespace Salon_System.Controllers.ViewModels
{
    public class ServiceEmployee
    {
        [Key]
        public int ServiceId { get; set; }

        [Key]
        public int EmployeeId { get; set; }

        public ServiceEmployee() { }
    }
}
