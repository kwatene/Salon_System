using Microsoft.AspNetCore.Mvc;
using Salon_System.Data;
using Salon_System.Models;

namespace Salon_System.Controllers
{
    public class ServiceCatController : Controller
    {
        public IActionResult Index() { return View(); }
    }
}