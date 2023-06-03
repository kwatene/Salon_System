using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.ViewComponents;
using Microsoft.EntityFrameworkCore;
using Salon_System.Data;
using Salon_System.Models;
using System.Linq.Expressions;

namespace Salon_System.Controllers
{
    public class ServiceController : Controller
    {
        private readonly FeathertouchDbContext db;

        public ServiceController(FeathertouchDbContext context)
        {
            this.db = context;
        }

        //---------------------------------------------------------------------------------------------------------------
        //VIEW ALL CLIENTS
        //---------------------------------------------------------------------------------------------------------------

        [HttpGet]
        public IActionResult Index()  //View list of Services (Main Services Page)
        {
            List<Service> serviceList = new();
            var list = db.Service.ToList();     //Get records from Service Table in db

            if (list != null)                   //If records exist
            {
                foreach (var service in list)        //Read each record in list
                {
                    var Service = new Service()      //Copy data from each record
                    {
                        Id = service.Id,
                        Name = service.Name,
                        Description = service.Description,
                        DurationHours = service.DurationHours,
                        DurationMins = service.DurationMins,
                        Charge = service.Charge,
                        CategoryName = GetCategoryName(service.CategoryId)
                    };

                    serviceList.Add(Service);        //Add record to servicelist
                }
                return View(serviceList);            //Use serviceList in view
            }
            return View(serviceList);
        }

        public string GetCategoryName(int? id)
        {           
            //Query db by Id to get the name of the Category
            var catName = db.ServiceCategory.Where(c => c.Id == id).Select(c => c.Name).SingleOrDefault();
           
            if (catName != null) //if found
            {                 
                return catName; //return category name
            }         
            return ""; //Else return null
        }

        public string GetEmployees(int? id)
        {
            //Query db by Id to get the FirstName and LastName of the Employee
            var emp = db.Employee.Where(e => e.Id == id).Select(e => new {e.FirstName, e.LastName }).SingleOrDefault();

            if (emp != null) //if found
            {
                string? FirstName = emp.FirstName;
                string? LastName = emp.LastName;
                return FirstName + " " + LastName; //return full name of employee
            }
            return ""; //else return null
        }

        //---------------------------------------------------------------------------------------------------------------
        //VIEW SELECTED CLIENT
        //---------------------------------------------------------------------------------------------------------------

        [HttpGet]
        public IActionResult Details(int id) //Display the selected clients details
        {
            try
            {
                var record = db.Service.SingleOrDefault(x => x.Id == id); //Find client record in database by id

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
                        CategoryName = GetCategoryName(record.CategoryId)
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
        public IActionResult Create() //Display the Service/Create View
        {
            List<ServiceCategory> categoryList = new();
            List<Employee> employeeList = new();
            var categories = db.ServiceCategory.ToList();
            var employees = db.Employee.ToList();

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
                            CategoryId = service.CategoryId
                        };
                        db.Service.Add(newService);                              //Add service record to database
                        db.SaveChanges();                                     //Save changes made to database
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
