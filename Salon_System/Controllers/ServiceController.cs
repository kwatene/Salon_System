using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.ViewComponents;
using Microsoft.EntityFrameworkCore;
using Salon_System.Data;
using Salon_System.Models;
using Salon_System.Models.ViewModels;

namespace Salon_System.Controllers
{
    public class ServiceController : Controller
    {
        private readonly FeathertouchDbContext _context;

        public ServiceController(FeathertouchDbContext context)
        {
            this._context = context;
        }

        //---------------------------------------------------------------------------------------------------------------
        //VIEW ALL CLIENTS
        //---------------------------------------------------------------------------------------------------------------

        [HttpGet]
        public IActionResult Index()  //View list of Services (Main Services Page)
        {
            List<Service> serviceList = new();
            var list = _context.Service.ToList();

            if (list != null)
            {
                foreach (var service in list)                                                                 //Add Records to list
                {
                    var Service = new Service()                                                               //Get information from database
                    {
                        Id = service.Id,
                        Name = service.Name,
                        Description = service.Description,
                        DurationHours = service.DurationHours,
                        DurationMins = service.DurationMins,
                        Charge = service.Charge,
                        CategoryId = service.CategoryId,
                        EmployeeId = service.EmployeeId
                    };
                    serviceList.Add(Service);                                                                   //Add record to list
                }
                return View(serviceList);                                                                       //Use list in view
            }
            return View(serviceList);
        }

        //---------------------------------------------------------------------------------------------------------------
        //VIEW SELECTED CLIENT
        //---------------------------------------------------------------------------------------------------------------

        [HttpGet]
        public IActionResult Details(int id) //Display the selected clients details
        {
            try
            {
                var record = _context.Service.SingleOrDefault(x => x.Id == id); //Find client record in database by id

                if (record != null) //if found
                {
                    var service = new Service() //Add details to client object
                    {
                        Id = record.Id,
                        Name = record.Name,
                        Description = record.Description,
                        DurationHours = record.DurationHours,
                        DurationMins = record.DurationMins,
                        Charge = record.Charge,
                        CategoryId = record.CategoryId,
                        EmployeeId = record.EmployeeId
                    };
                    return View(service); //Display client details
                }
                else
                {
                    TempData["errorMessage"] = $"Service details are not available with ID: {id}"; //If not found - Display message
                    return RedirectToAction("Index"); //Redirect to Client list
                }
            }
            catch (Exception ex)
            {
                TempData["errorMessage"] = ex.Message;
                return RedirectToAction("Index");
            }
        }

        //---------------------------------------------------------------------------------------------------------------
        //CREATE METHODS
        //---------------------------------------------------------------------------------------------------------------


        [HttpGet]
        public dynamic Create() //Display the Service/Create View
        {
            List<ServiceCategory> categoryList = new();
            List<Employee> employeeList = new();
            var categories = _context.ServiceCategory.ToList();
            var employees = _context.Employee.ToList();

            if (categories != null) //Select Category for Service
            {
                foreach (var c in categories)
                {
                    var Category = new ServiceCategory()
                    {
                        Id = c.Id,
                        Name = c.Name
                    };
                    categoryList.Add(Category);
                }
                ViewBag.Categories = categoryList;
            }

            if(employees != null) //Select Capable staff for Service
            {
                foreach (var e in employees)
                {
                    var Employee = new Employee()
                    {
                        Id = e.Id,
                        FirstName = e.FirstName,
                        LastName = e.LastName
                    };
                    employeeList.Add(Employee);
                }
                ViewBag.Employees = employeeList;
            }

            return View();
        }

        [HttpPost]
        public IActionResult Create(Service service) //Creates and saves a new Service in the system
        {
            try
            {
                if (ModelState.IsValid)
                {
                        var newService = new Service() //If valid, add input to Service object
                        {
                            Name = service.Name,
                            Description = service.Description,
                            DurationHours = service.DurationHours,
                            DurationMins = service.DurationMins,
                            Charge = service.Charge,
                            CategoryId = service.CategoryId,
                            EmployeeId = service.EmployeeId
                        };
                        _context.Service.Add(service);                              //Add service record to database
                        _context.SaveChanges();                                     //Save changes made to database
                        TempData["successMessage"] = "New Client Added";            //Display success message
                        return RedirectToAction("Index");                           //Redirect user to Service list
                }
                else
                {
                    TempData["errorMessage"] = "Invalid form"; //If form invalid show error message
                    return View();
                }
            }
            catch (Exception ex)
            {
                TempData["errorMessage"] = ex.Message;
                return View();
            }
        }

        //---------------------------------------------------------------------------------------------------------------
        //UPDATE METHODS
        //---------------------------------------------------------------------------------------------------------------

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
