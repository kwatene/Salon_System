using Microsoft.AspNetCore.Mvc;

namespace Salon_System.Controllers
{
    public class ServicePackage : Controller
    {
        public IActionResult Index()
        {
            return View();
        }
    }
}
