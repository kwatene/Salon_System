using System.ComponentModel;
using System.ComponentModel.DataAnnotations;

namespace Salon_System.Models
{
    public class ServiceCategory
    {
        public int Id { get; set; }

        [DisplayName("Name"), Required(ErrorMessage = "This field is required")] public string? Name { get; set; }

        public ServiceCategory() { }

        //Consructor to display category names
        public ServiceCategory(int id, string name) 
        {
            Id = id;
            Name = name;
        }
    }
}
