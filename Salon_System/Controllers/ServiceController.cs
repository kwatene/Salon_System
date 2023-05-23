using Microsoft.AspNetCore.Mvc;
using Salon_System.Data;
using Salon_System.Models;

namespace Salon_System.Controllers
{
    public class ServiceController : Controller
    {
        private readonly FeathertouchDbContext _context;

        public ServiceController(FeathertouchDbContext context)
        {
            this._context = context;
        }

        [HttpGet]
        public IActionResult Index()  //View list of Services (Main Services Page)
        {
            List<Service> serviceList = new();
            var list = _context.Service.ToList();

            if (list != null)
            {
                foreach (var service in list)
                {
                    var Service = new Service()
                    {
                        Id = service.Id,
                        Name = service.Name,
                        Description = service.Description,
                        Duration = service.Duration,
                        Charge = service.Charge
                    };
                    serviceList.Add(Service);
                }
                return View(serviceList);
            }
            return View(serviceList);
        }

        //Create a new Service
        public IActionResult Create()
        {
            //Assign Service Category
            //Assign Consent
            //Apply Age Restriction
            return View();
        }

        //Update an existing Service
        public IActionResult Update()
        {
            return View();
        }

        //Delete a Service
        public IActionResult Delete()
        {
            return View();
        }
        public IActionResult AddEmployee()
        {
            return View();
        }
    }
}
