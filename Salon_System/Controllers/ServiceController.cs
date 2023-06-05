using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.ViewComponents;
using Microsoft.EntityFrameworkCore;
using Salon_System.Controllers.ViewModels;
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
        //VIEW ALL SERVICES
        //---------------------------------------------------------------------------------------------------------------

        [HttpGet]
        public IActionResult Index()                 //View list of Services
        {
            List<Service> serviceList = new();
            var list = db.Service.ToList();          //Get records from Service Table in db

            if (list != null)                        //If records exist
            {
                foreach (var service in list)        //Read each record in list
                {

                    var Service = new Service()
                    {
                        Id = service.Id,
                        Name = service.Name,
                        Description = service.Description,
                        DurationHours = service.DurationHours,
                        DurationMins = service.DurationMins,
                        Charge = service.Charge,
                        CategoryName = GetCategoryName(service.CategoryId)
                    };

                    ViewBag.Employees = GetCapableStaff(Service.Id);
                    serviceList.Add(Service);
                }
                return View(serviceList);            //Display serviceList in view
            }
            return View(serviceList);
        }

        public List<String>? GetCapableStaff(int? id)         //Get names of Employees associated with the service to display
        {
            //Query db to get the FirstName and LastName of the Employee
            var Employee = db.ServiceEmployee.Where(se => se.ServiceId == id)
                         .Join(db.Employee,
                             se => se.EmployeeId,
                             e => e.Id,
                             (se, e) => e.FirstName + " " + e.LastName + " ").ToList();

            if (Employee != null)
            {
                return Employee;            //Return List of Names
            }
            return null;
        }

        //---------------------------------------------------------------------------------------------------------------
        //VIEW SELECTED SERVICE
        //---------------------------------------------------------------------------------------------------------------

        [HttpGet]
        public IActionResult Details(int id)                              //Display the selected clients details
        {
            try
            {
                var service = db.Service.SingleOrDefault(x => x.Id == id); //Find client in db

                if (service != null)                                       //if found
                {
                    var Service = new Service()                           //Get client details
                    {
                        Id = service.Id,
                        Name = service.Name,
                        Description = service.Description,
                        DurationHours = service.DurationHours,
                        DurationMins = service.DurationMins,
                        Charge = service.Charge,
                        CategoryName = GetCategoryName(service.CategoryId)
                    };
                    return View(Service);                                 //Display client details
                }
                else
                {
                    TempData["errorMessage"] = $"Service details are not available with ID: {id}"; //If not found - Display message
                    return RedirectToAction("Index");                     //Redirect to Client list
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
        public IActionResult Create()                                   //Display the Service/Create View/Form
        {
            List<ServiceCategory> categoryList = new();
            var category = db.ServiceCategory.ToList();

            if (category != null)                                     //Display the Categories for user to select
            {
                foreach (var c in category)
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

            /*if(employees != null) //Select Capable staff for Service
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
            }*/

            return View();
        }

        [HttpPost]
        public IActionResult Create(Service service, int[]EmployeeIds)   //Retrieve form details to create and save a new Service in the system
        {
            try
            {
                if (ModelState.IsValid)
                {
                    var Service = new Service()                          //Add service record to database
                    {
                        Name = service.Name,
                        Description = service.Description,
                        DurationHours = service.DurationHours,
                        DurationMins = service.DurationMins,
                        Charge = service.Charge,
                        CategoryId = service.CategoryId
                    };
                    db.Service.Add(Service);
                    db.SaveChanges();                                     //Save changes made to Service Table

                    foreach (var empId in EmployeeIds)                    //Associate employees with the Service
                    {                                                    
                        var Employee = new ServiceEmployee()
                        { 
                            ServiceId = service.Id,
                            EmployeeId = empId
                        };
                        db.ServiceEmployee.Add(Employee);
                        db.SaveChanges();                                    //Save changes made to ServiceEmployee composite table
                    }

                    TempData["successMessage"] = "Added new Service: " + service.Name;      //Display success message

                    return RedirectToAction("Index");                                       //Redirect user to Service list
                }
                else
                {
                    ViewBag.Employees = db.Employee.ToList();
                    TempData["errorMessage"] = "Invalid form";           //If form invalid show error message
                    return View(service);
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

        public string GetCategoryName(int? id)      //Get name of category to display
        {
            //Query db to get category name
            var catName = db.ServiceCategory.Where(c => c.Id == id).Select(c => c.Name).SingleOrDefault();

            if (catName != null)                    //if found
            {
                return catName;                     //return category name
            }
            return "Not found";                     //Else not found
        }
    }
}
