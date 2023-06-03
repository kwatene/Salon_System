using Salon_System.Models;
using Microsoft.EntityFrameworkCore;
using Salon_System.Controllers.ViewModels;

namespace Salon_System.Data
{
    public class FeathertouchDbContext : DbContext
    {
        //Constructor for DBContext
        public FeathertouchDbContext(DbContextOptions options) : base(options)
        {
        }

        //Dataset for Customer class
        public DbSet<Client> Client { get; set; }

        //Dataset for Employee class
        public DbSet<Employee> Employee { get; set; }

        //Dataset for Service class
        public DbSet<Service> Service { get; set; }

        //Dataset for Service Category
        public DbSet<ServiceCategory> ServiceCategory { get; set; }

        //Dataset for Composite Table ServiceEmployee
        public DbSet<ServiceEmployee> ServiceEmployee { get; set; }

        //Dataset for Service Package
        //public DbSet<ServicePack> ServicePack { get; set; }
    }
}
