using Microsoft.EntityFrameworkCore;

namespace Salon_System.Models.ViewModels
{
    public class ServiceView
    {
        public Service? Service { get; set; }
        public List<ServiceCategory>? Categories { get; set; }
    }
}
